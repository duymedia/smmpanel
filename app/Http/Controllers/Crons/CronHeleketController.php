<?php

namespace App\Http\Controllers\Crons;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class CronHeleketController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $method = PaymentMethod::where('domain', getDomain())
            ->where('type', PaymentMethod::TYPE_HELEKET)
            ->find($request->integer('type'));
        if (!$method) return response()->json(['state' => 1, 'message' => 'Payment method not found.'], 404);

        $config = $method->parsed_config;
        $secrets = is_array($config['options_hide'] ?? null) ? $config['options_hide'] : [];
        $apiKey = (string) ($secrets['payment_api_key'] ?? '');
        if ($apiKey !== '') {
            try {
                $apiKey = Crypt::decryptString($apiKey);
            } catch (\Throwable) {
                // Support credentials saved before encryption was enabled.
            }
        }
        if ($apiKey === '') return response()->json(['state' => 1, 'message' => 'Payment API key is not configured.'], 503);

        $payload = json_decode($request->getContent(), true);
        if (!is_array($payload) || !is_string($payload['sign'] ?? null)) {
            return response()->json(['state' => 1, 'message' => 'Invalid webhook payload.'], 400);
        }

        $signature = $payload['sign'];
        unset($payload['sign']);
        $body = json_encode($payload, JSON_UNESCAPED_UNICODE);
        if (!is_string($body) || !hash_equals(md5(base64_encode($body) . $apiKey), $signature)) {
            return response()->json(['state' => 1, 'message' => 'Invalid webhook signature.'], 403);
        }

        if (($payload['type'] ?? null) !== 'payment' || empty($payload['order_id'])) {
            return response()->json(['state' => 1, 'message' => 'Unsupported invoice callback.'], 422);
        }

        $status = strtolower((string) ($payload['status'] ?? $payload['payment_status'] ?? ''));
        if (!in_array($status, ['paid', 'paid_over'], true)) {
            $final = filter_var($payload['is_final'] ?? false, FILTER_VALIDATE_BOOLEAN);
            if (in_array($status, ['fail', 'cancel', 'system_fail'], true) || ($status === 'wrong_amount' && $final)) {
                Payment::where('domain', getDomain())
                    ->where('payment_method_id', $method->id)
                    ->where('transaction_id', (string) $payload['order_id'])
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'failed',
                        'payment_info->heleket_status' => $status,
                    ]);
            }
            return response()->json(['state' => 0, 'message' => 'Callback acknowledged.']);
        }

        try {
            $credited = DB::transaction(function () use ($method, $payload, $status): ?array {
                $payment = Payment::where('domain', getDomain())
                    ->where('payment_method_id', $method->id)
                    ->where('transaction_id', (string) $payload['order_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$payment) return null;
                if ($payment->status === 'completed') return ['duplicate' => true];
                if ($payment->status !== 'pending') return ['duplicate' => true];

                $invoiceAmount = (float) $payment->amount;
                $invoiceCurrency = strtoupper((string) $payment->currency);
                $expectedUuid = $payment->payment_info['invoice_uuid'] ?? null;
                if (
                    abs((float) ($payload['amount'] ?? 0) - $invoiceAmount) > 0.00000001 ||
                    strtoupper((string) ($payload['currency'] ?? '')) !== $invoiceCurrency ||
                    ($expectedUuid && !hash_equals((string) $expectedUuid, (string) ($payload['uuid'] ?? '')))
                ) {
                    $payment->update([
                        'status' => 'failed',
                        'payment_info' => array_merge($payment->payment_info ?? [], [
                            'heleket_status' => $status,
                            'verification_error' => 'Invoice amount or currency mismatch',
                        ]),
                    ]);
                    return ['mismatch' => true];
                }

                $paidAmount = $invoiceAmount;
                $bonusPercent = $this->bonusPercent($method, $paidAmount);
                $bonusAmount = round($paidAmount * $bonusPercent / 100, 8);
                $creditAmount = round($paidAmount + $bonusAmount, 8);
                $user = User::whereKey($payment->user_id)
                    ->where('domain', getDomain())
                    ->lockForUpdate()
                    ->first();
                if (!$user) return null;

                $balanceBefore = (float) $user->balance;
                $user->balance = round($balanceBefore + $creditAmount, 8);
                if (isset($user->total_deposit)) {
                    $user->total_deposit = round((float) $user->total_deposit + $paidAmount, 8);
                }
                $user->save();

                $payment->update([
                    'amount' => $paidAmount,
                    'bonus_amount' => $bonusAmount,
                    'total_amount' => $creditAmount,
                    'status' => 'completed',
                    'note' => 'Heleket deposit ' . $status,
                    'payment_info' => array_merge($payment->payment_info ?? [], [
                        'provider' => 'heleket',
                        'heleket_uuid' => $payload['uuid'] ?? null,
                        'heleket_status' => $status,
                        'payment_amount' => $payload['payment_amount'] ?? null,
                        'payment_amount_usd' => $payload['payment_amount_usd'] ?? null,
                        'payer_currency' => $payload['payer_currency'] ?? null,
                        'network' => $payload['network'] ?? null,
                        'txid' => $payload['txid'] ?? null,
                        'bonus_percent' => $bonusPercent,
                    ]),
                ]);

                Transaction::create([
                    'user_id' => $user->id,
                    'amount' => $creditAmount,
                    'type' => 'deposit',
                    'status' => 'completed',
                    'payment_method' => $method->name,
                    'transaction_id' => $payment->transaction_id,
                    'description' => 'Heleket deposit ' . $payment->transaction_id,
                    'balance_after' => $user->balance,
                    'domain' => getDomain(),
                ]);

                return ['user_id' => $user->id, 'amount' => $paidAmount, 'duplicate' => false];
            });

            if ($credited === null) return response()->json(['state' => 1, 'message' => 'Invoice not found.'], 404);
            if (!empty($credited['mismatch'])) {
                Log::warning('Heleket invoice amount/currency mismatch', ['order_id' => $payload['order_id']]);
                return response()->json(['state' => 1, 'message' => 'Invoice amount or currency mismatch.'], 422);
            }
            if (empty($credited['duplicate'])) {
                try {
                    \App\Services\AffiliateService::handleDeposit($credited['user_id'], $credited['amount'], (string) $payload['order_id']);
                } catch (\Throwable $exception) {
                    report($exception);
                }
            }

            return response()->json(['state' => 0, 'message' => 'Callback processed.']);
        } catch (\Throwable $exception) {
            report($exception);
            Log::error('Heleket webhook processing failed', ['order_id' => $payload['order_id']]);
            return response()->json(['state' => 1, 'message' => 'Webhook processing failed.'], 500);
        }
    }

    private function bonusPercent(PaymentMethod $method, float $amount): float
    {
        $tiers = $method->bonus;
        if (is_string($tiers)) $tiers = json_decode($tiers, true);
        if (!is_array($tiers)) return 0;

        $percent = 0;
        foreach ($tiers as $tier) {
            if (is_array($tier) && (float) ($tier['min'] ?? 0) <= $amount) {
                $percent = max($percent, (float) ($tier['percent'] ?? 0));
            }
        }
        return max(0, min(100, $percent));
    }
}
