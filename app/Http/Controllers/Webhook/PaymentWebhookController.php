<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\{Payment, User, Currency, PaymentMethod};
use Illuminate\Http\{Request, JsonResponse};
use Illuminate\Support\Facades\{DB, Log};

class PaymentWebhookController extends Controller
{
    public function handlePayment(Request $request): JsonResponse
    {
        try {
            // Get PaymentMethod from query parameter (type = payment_method_id)
            $paymentMethodId = $request->query('type');
            $paymentMethod = PaymentMethod::find($paymentMethodId);

            if (!$paymentMethod) {
                Log::warning('Webhook: Payment method not found', ['method_id' => $paymentMethodId]);
                return response()->json(['status' => false, 'msg' => 'Payment method not found'], 404);
            }

            if ($request->isMethod('GET')) {
                return response()->json(['status' => true, 'msg' => 'OK']);
            }

            Log::info('Webhook received', ['url' => $request->fullUrl(), 'body' => $request->all()]);

            return response()->json($this->processTransactions($paymentMethod, $request));
        } catch (\Exception $e) {
            Log::error('Webhook error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['status' => false, 'msg' => 'Internal server error'], 500);
        }
    }

    private function processTransactions(PaymentMethod $paymentMethod, Request $request): array
    {
        $transactions = $request->input('transactions', []);

        if (!is_array($transactions) || empty($transactions)) {
            Log::warning('Webhook: Invalid data format - empty transactions');
            return ['status' => false, 'msg' => 'Invalid data format'];
        }

        $processed = 0;
        $failed = 0;

        DB::transaction(function () use ($paymentMethod, $transactions, &$processed, &$failed) {
            foreach ($transactions as $txn) {
                try {
                    if ($this->handleTransaction($paymentMethod, $txn)) {
                        $processed++;
                    } else {
                        $failed++;
                    }
                } catch (\Exception $e) {
                    Log::error('Transaction processing error', [
                        'transaction_id' => $txn['transactionID'] ?? 'unknown',
                        'error' => $e->getMessage()
                    ]);
                    $failed++;
                }
            }
        });

        // Log summary
        Log::info('Webhook: Batch processing completed', [
            'processed' => $processed,
            'failed' => $failed,
            'total' => count($transactions)
        ]);

        // Return simple response format matching bank's format
        return [
            'status' => true,
            'msg' => 'OK'
        ];
    }

    private function handleTransaction(PaymentMethod $paymentMethod, array $data): bool
    {
        // Validate required fields
        if (!isset($data['type'], $data['transactionID'], $data['amount'], $data['description'])) {
            Log::warning('Webhook: Missing required fields', ['data' => $data]);
            return false;
        }

        // Only process incoming transactions
        if ($data['type'] !== 'IN') {
            return false;
        }

        // Extract transfer code from description
        // Format: "NAP14838 GD 941234-010624 16:56:30" or "IB NAP1531"
        // Transfer code is the first word starting with NAP
        $transferCode = $this->extractTransferCode($data['description']);

        if (!$transferCode) {
            Log::warning('Webhook: Could not extract transfer code', ['description' => $data['description']]);
            return false;
        }

        // Find user by transfer code
        $user = User::where('transfer_code', $transferCode)->first();

        if (!$user) {
            Log::warning('Webhook: User not found', ['transfer_code' => $transferCode]);
            return false;
        }

        // Check if transaction already processed
        if (Payment::where('transaction_id', $data['transactionID'])->where('user_id', $user->id)->exists()) {
            Log::info('Webhook: Transaction already processed', ['transaction_id' => $data['transactionID']]);
            return false;
        }

        // Process the deposit
        $this->processDeposit($user, $paymentMethod, (float) $data['amount'], $data['transactionID'], $data['description']);

        return true;
    }

    private function extractTransferCode(string $description): ?string
    {
        // Extract transfer code from description
        // Look for pattern like "NAP14838" or similar
        $parts = explode(' ', trim($description));

        foreach ($parts as $part) {
            $part = trim($part);
            // Transfer code typically starts with NAP or similar prefix
            if (preg_match('/^NAP\d+$/i', $part)) {
                return strtoupper($part);
            }
        }

        // Fallback: try first word if it looks like a code
        $firstWord = trim($parts[0] ?? '');
        if (!empty($firstWord) && strlen($firstWord) >= 3) {
            return strtoupper($firstWord);
        }

        return null;
    }

    private function processDeposit(User $user, PaymentMethod $paymentMethod, float $amountVND, string $transactionId, string $description): void
    {
        // Get VND exchange rate
        $vndCurrency = Currency::where('code', 'VND')->where('status', 1)->first();
        $vndRate = $vndCurrency?->exchange_rate ?? 26000;

        // Convert VND to base currency (USD)
        $amountUSD = $amountVND / $vndRate;

        // Calculate bonus based on payment method's bonus tiers
        $bonusData = $this->calculateBonus($amountVND, $paymentMethod->bonus);
        $bonusAmountVND = $bonusData['bonus_amount'];
        $bonusAmountUSD = $bonusAmountVND / $vndRate;

        // Update user balance
        $user->balance += $amountUSD + $bonusAmountUSD;
        $user->save();

        // Create payment record
        Payment::create([
            'user_id' => $user->id,
            'payment_method_id' => $paymentMethod->id,
            'transaction_id' => $transactionId,
            'amount' => $amountVND,
            'bonus_amount' => $bonusAmountVND,
            'total_amount' => $amountVND + $bonusAmountVND,
            'currency' => 'VND',
            'exchange_rate' => $vndRate,
            'status' => 'completed',
            'note' => $description,
            'payment_info' => [
                'vnd_amount' => $amountVND,
                'bonus_percent' => $bonusData['bonus_percent'],
                'webhook' => true,
                'type' => 'bank_transfer'
            ],
            'domain' => getDomain()
        ]);

        // Handle affiliate commission (only on deposit amount, not bonus)
        if (class_exists('App\Services\AffiliateService')) {
            \App\Services\AffiliateService::handleDeposit($user->id, $amountUSD, $transactionId);
        }

        Log::info('Webhook: Deposit processed successfully', [
            'user_id' => $user->id,
            'transaction_id' => $transactionId,
            'amount_vnd' => $amountVND,
            'amount_usd' => $amountUSD,
            'bonus_vnd' => $bonusAmountVND
        ]);
    }

    private function calculateBonus(float $amount, ?string $bonusJson): array
    {
        $bonusAmount = 0;
        $bonusPercent = 0;

        if (!$bonusJson) {
            return ['bonus_amount' => 0, 'bonus_percent' => 0];
        }

        try {
            $bonusTiers = json_decode($bonusJson, true);
            if (!is_array($bonusTiers)) {
                return ['bonus_amount' => 0, 'bonus_percent' => 0];
            }

            // Find the highest tier that matches the amount
            foreach ($bonusTiers as $tier) {
                if (isset($tier['min'], $tier['percent']) && $amount >= $tier['min']) {
                    $bonusPercent = $tier['percent'];
                }
            }

            // Calculate bonus amount
            if ($bonusPercent > 0) {
                $bonusAmount = ($amount * $bonusPercent) / 100;
            }

            return [
                'bonus_amount' => $bonusAmount,
                'bonus_percent' => $bonusPercent,
            ];
        } catch (\Exception $e) {
            Log::error('Bonus calculation error', ['error' => $e->getMessage()]);
            return ['bonus_amount' => 0, 'bonus_percent' => 0];
        }
    }
}
