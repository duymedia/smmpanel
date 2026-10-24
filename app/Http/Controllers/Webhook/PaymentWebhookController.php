<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\{Payment, User, Currency, PaymentMethod};
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\{DB, Log};
use Illuminate\Support\Str;

class PaymentWebhookController extends Controller
{
    public function handlePayment(Request $request): JsonResponse
    {
        try {
            $paymentMethod = PaymentMethod::find($request->query('type'));

            if (!$paymentMethod) {
                return response()->json(['status' => false, 'msg' => 'Payment method not found'], 404);
            }

            if ($request->isMethod('GET')) {
                return response()->json(['status' => true, 'msg' => 'OK']);
            }

            Log::info('Webhook received', ['body' => $request->all()]);

            // Lấy transactions (hỗ trợ nhiều key + single transaction)
            $transactions = $request->input('transactions') ?? $request->input('data') ?? [];
            if (isset($transactions['transactionID']) || isset($transactions['transaction_id'])) {
                $transactions = [$transactions];
            }

            if (empty($transactions)) {
                return response()->json(['status' => false, 'msg' => 'No transactions']);
            }

            $processed = 0;

            foreach ($transactions as $raw) {
                // Normalize fields từ nhiều format bank
                $txnId       = (string) ($raw['transactionID'] ?? $raw['transaction_id'] ?? $raw['id'] ?? '');
                $amount      = (float)  ($raw['amount'] ?? $raw['money'] ?? $raw['value'] ?? 0);
                $description = trim((string) ($raw['description'] ?? $raw['desc'] ?? $raw['content'] ?? $raw['memo'] ?? ''));
                $type        = strtoupper($raw['type'] ?? $raw['transferType'] ?? '');

                // Normalize type
                if (in_array($type, ['CREDIT', 'CR', '+'])) $type = 'IN';
                if (in_array($type, ['DEBIT', 'DR', '-'])) $type = 'OUT';

                // Chỉ xử lý tiền VÀO + có đủ data
                if ($type !== 'IN' || !$txnId || !$amount || !$description) continue;

                // Tìm user từ description
                $user = $this->findUser($description);
                if (!$user) {
                    Log::warning('Webhook: User not found', ['desc' => $description]);
                    continue;
                }

                // Check trùng
                if (Payment::where('transaction_id', $txnId)->where('user_id', $user->id)->exists()) continue;

                // Xử lý nạp tiền
                DB::transaction(function () use ($user, $paymentMethod, $amount, $txnId, $description) {
                    $vndRate = Currency::where('code', 'VND')->where('status', 1)->value('exchange_rate') ?? 26000;
                    $amountUSD = $amount / $vndRate;

                    // Bonus
                    $bonus = $this->getBonus($amount, $paymentMethod);
                    $bonusUSD = $bonus['amount'] / $vndRate;

                    // Cộng balance + đổi transfer_code
                    $user->balance += $amountUSD + $bonusUSD;
                    $user->transfer_code = Str::random(8);
                    $user->save();

                    // Tạo record
                    Payment::create([
                        'user_id' => $user->id,
                        'payment_method_id' => $paymentMethod->id,
                        'transaction_id' => $txnId,
                        'amount' => $amount,
                        'bonus_amount' => $bonus['amount'],
                        'total_amount' => $amount + $bonus['amount'],
                        'currency' => 'VND',
                        'exchange_rate' => $vndRate,
                        'status' => 'completed',
                        'note' => $description,
                        'payment_info' => ['bonus_percent' => $bonus['percent'], 'webhook' => true],
                        'domain' => getDomain()
                    ]);

                    // Affiliate
                    if (class_exists('App\Services\AffiliateService')) {
                        \App\Services\AffiliateService::handleDeposit($user->id, $amountUSD, $txnId);
                    }

                    Log::info('Webhook: Deposit OK', ['user' => $user->id, 'txn' => $txnId, 'vnd' => $amount]);
                });

                $processed++;
            }

            return response()->json(['status' => true, 'msg' => 'OK', 'processed' => $processed]);
        } catch (\Exception $e) {
            Log::error('Webhook error', ['error' => $e->getMessage()]);
            return response()->json(['status' => false, 'msg' => 'Internal server error'], 500);
        }
    }

    /**
     * Tìm user bằng transfer_code trong description
     */
    private function findUser(string $description): ?User
    {
        foreach (preg_split('/[\s\-\/]+/', $description) as $word) {
            if (strlen($word) < 4) continue;
            $user = User::where('transfer_code', $word)->first();
            if ($user) return $user;
        }
        // Legacy NAP format
        foreach (preg_split('/[\s\-\/]+/', $description) as $word) {
            if (preg_match('/^NAP\d+$/i', $word)) {
                $user = User::where('transfer_code', strtoupper($word))->first();
                if ($user) return $user;
            }
        }
        return null;
    }

    /**
     * Tính bonus từ payment method config
     */
    private function getBonus(float $amount, PaymentMethod $paymentMethod): array
    {
        $config = $paymentMethod->config ? json_decode($paymentMethod->config, true) : null;
        $json = $config['bonus'] ?? $paymentMethod->bonus ?? null;
        $tiers = is_string($json) ? json_decode($json, true) : (is_array($json) ? $json : null);

        if (!is_array($tiers)) return ['amount' => 0, 'percent' => 0];

        $percent = 0;
        foreach ($tiers as $tier) {
            if (isset($tier['min'], $tier['percent']) && $amount >= $tier['min']) {
                $percent = $tier['percent'];
            }
        }

        return [
            'amount' => $percent > 0 ? ($amount * $percent / 100) : 0,
            'percent' => $percent,
        ];
    }
}
