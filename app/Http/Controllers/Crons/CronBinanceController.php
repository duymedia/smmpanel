<?php

namespace App\Http\Controllers\Crons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{Payment, User, Transaction, Currency, PaymentMethod};

class CronBinanceController extends Controller
{
    public function __invoke(Request $request)
    {
        return $this->handle($request);
    }

    public function binanceStore(Request $request)
    {
        return $this->handle($request);
    }

    public function binance(Request $request)
    {
        // Lấy orderId, expectedAmount và user_id từ request
        $orderId = $request->input('orderId');
        $expectedAmount = (float) $request->input('amount', 0);
        $userId = $request->input('user_id');
        $checkoutId = $request->input('checkout_id');

        if (!$orderId) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu orderId'
            ]);
        }

        // Lấy user từ authenticated session hoặc từ user_id parameter
        $user = $request->user();

        // Nếu có user_id từ request, kiểm tra xem có khớp với authenticated user không
        if ($userId) {
            if ($user && (int)$user->id !== (int)$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID không khớp với user đang đăng nhập'
                ]);
            }
            // Nếu không có authenticated user, lấy user từ user_id
            if (!$user) {
                $user = User::find($userId);
            }
        }

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thực hiện giao dịch'
            ]);
        }

        // Lấy config từ bảng payment_methods với type = 'binance'
        if ($checkoutId) {
            $checkout = Transaction::where('id', $checkoutId)
                ->where('user_id', $user->id)
                ->where('type', 'deposit')
                ->where('status', 'pending')
                ->first();

            if (!$checkout) {
                return response()->json([
                    'success' => false,
                    'message' => 'Checkout không tồn tại hoặc đã được xử lý.'
                ], 404);
            }

            if (abs((float) $checkout->amount - $expectedAmount) > 0.01) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số tiền checkout không khớp.'
                ], 422);
            }
        }

        $binanceMethod = PaymentMethod::where('domain', getDomain())
            ->where('type', 'binance')
            ->where('status', true)
            ->first();

        if (!$binanceMethod) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy cấu hình Binance'
            ]);
        }

        $config = json_decode($binanceMethod->config, true) ?? [];
        $apiKey    = $config['key'] ?? null;
        $apiSecret = $config['secret'] ?? ($config['options_hide']['secret'] ?? null);
        $binanceId = $config['binance_id'] ?? null;

        if (!$apiKey || !$apiSecret || !$binanceId) {
            return response()->json([
                'success' => false,
                'message' => 'Thiếu API Key, Secret Key hoặc Binance ID'
            ]);
        }

        // Gọi API Binance
        $daysBack = 7;
        $endpoint = 'https://api.binance.com/sapi/v1/pay/transactions';
        $nowMs    = (int) (microtime(true) * 1000);
        $startMs  = $nowMs - ($daysBack * 24 * 60 * 60 * 1000);

        $params = [
            'transactionType' => 1,
            'startTime'       => $startMs,
            'endTime'         => $nowMs,
            'limit'           => 100,
            'recvWindow'      => 60000,
            'timestamp'       => $nowMs,
        ];

        ksort($params);
        $query     = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $signature = hash_hmac('sha256', $query, $apiSecret);
        $url       = $endpoint . '?' . $query . '&signature=' . $signature;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => ['X-MBX-APIKEY: ' . $apiKey],
        ]);
        $raw = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi kết nối API Binance'
            ]);
        }

        $res = json_decode($raw, true);
        $transactions = $res['data'] ?? [];

        // Tìm transaction theo orderId
        $transaction = null;
        foreach ($transactions as $tx) {
            if (($tx['orderId'] ?? '') == $orderId || ($tx['transactionId'] ?? '') == $orderId) {
                $transaction = $tx;
                break;
            }
        }

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy giao dịch'
            ]);
        }



        // Lấy amount từ fundsDetail
        $fundsDetail = $transaction['fundsDetail'] ?? [];
        $totalAmount = 0;
        foreach ($fundsDetail as $fund) {
            $totalAmount += (float) ($fund['amount'] ?? 0);
        }

        if ($totalAmount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Số tiền không hợp lệ'
            ]);
        }

        // Kiểm tra amount từ input và amount từ API
        if ($expectedAmount > 0) {
            // Cho phép sai lệch 0.01 (do làm tròn)
            if (abs($totalAmount - $expectedAmount) > 0.01) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số tiền không khớp. Bạn nhập: ' . number_format($expectedAmount, 2) . ' USDT, nhưng giao dịch thực tế: ' . number_format($totalAmount, 2) . ' USDT'
                ]);
            }
        }

        // Kiểm tra giao dịch đã tồn tại chưa từ Payment
        $existingPayment = Payment::where('transaction_id', 'BINANCE_' . $orderId)
            ->where('domain', getDomain())
            ->first();

        if ($existingPayment && $existingPayment->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Giao dịch đã được xử lý trước đó'
            ]);
        }

        // Cập nhật balance cho user
        try {
            DB::transaction(function () use ($user, $totalAmount, $binanceMethod, $orderId, $request) {
                // Tính bonus
                $bonusData = $this->calculateBonus($totalAmount, $binanceMethod->bonus);
                $bonusAmount = $bonusData['bonus_amount'];
                $creditedAmount = $totalAmount + $bonusAmount;

                $user->balance += $creditedAmount;
                $user->save();

                // Tạo Payment record
                Payment::create([
                    'user_id'           => $user->id,
                    'payment_method_id' => $binanceMethod->id,
                    'transaction_id'    => 'BINANCE_' . $orderId,
                    'amount'            => $totalAmount,
                    'bonus_amount'      => $bonusAmount,
                    'total_amount'      => $totalAmount + $bonusAmount,
                    'currency'          => 'USDT',
                    'exchange_rate'     => 1,
                    'status'            => 'completed',
                    'note'              => 'Nạp tiền Binance - Order: ' . $orderId,
                    'payment_info'      => [
                        'binance_order_id' => $orderId,
                        'binance_amount'   => $totalAmount,
                        'binance_asset'    => 'USDT',
                    ],
                    'domain'            => getDomain(),
                ]);

                Transaction::create([
                    'user_id'        => $user->id,
                    'order_id'       => null,
                    'amount'         => $creditedAmount,
                    'type'           => 'deposit',
                    'status'         => 'completed',
                    'payment_method' => $binanceMethod->name,
                    'transaction_id' => 'BINANCE_' . $orderId,
                    'description'    => 'Binance deposit - Order: ' . $orderId,
                    'balance_after'  => $user->balance,
                    'domain'         => getDomain(),
                ]);
            });

            // Affiliate commission
            \App\Services\AffiliateService::handleDeposit($user->id, $totalAmount, 'BINANCE_' . $orderId);

            return response()->json([
                'success' => true,
                'message' => 'Cron job binance completed',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ]);
        }
    }

    protected function handle(Request $request)
    {
        $request->validate([
            'amount'   => 'required|numeric|min:0.1',
            'order_id' => 'required|string',
            'method'   => 'nullable|string',
        ]);

        $user = $request->user();
        if (!$user) {
            return $this->error('UNAUTHENTICATED', 'Vui lòng đăng nhập.');
        }

        // Lấy config Binance từ payment_methods
        $binanceMethod = PaymentMethod::where('domain', getDomain())
            ->where('type', 'binance')
            ->where('status', true)
            ->first();

        if (!$binanceMethod) {
            return $this->error('BINANCE_NOT_CONFIGURED', 'Thiếu cấu hình Binance.');
        }

        $config = json_decode($binanceMethod->config, true) ?? [];
        $apiKey    = $config['key'] ?? null;
        $apiSecret = $config['secret'] ?? ($config['options_hide']['secret'] ?? null);
        $binanceId = $config['binance_id'] ?? null;

        if (!$apiKey || !$apiSecret || !$binanceId) {
            return $this->error('BINANCE_NOT_CONFIGURED', 'Thiếu cấu hình Binance.');
        }

        $clientAmount = (float) $request->input('amount');
        $orderIdInput = trim($request->input('order_id'));
        // chặn nạp lại - kiểm tra từ Payment
        $existingPayment = Payment::where('transaction_id', $orderIdInput)
            ->where('domain', getDomain())
            ->first();

        if ($existingPayment && $existingPayment->status === 'completed') {
            return $this->error('DUPLICATED_ORDER', 'Order ID này đã được xử lý.', [
                'order_id' => $orderIdInput,
            ], 409);
        }

        if ($existingPayment && in_array($existingPayment->status, ['pending', 'processing'])) {
            return $this->error('DUPLICATED_ORDER', 'Order ID này đang được xử lý.', [
                'order_id' => $orderIdInput,
            ], 409);
        }

        // lấy giao dịch từ Binance
        $binanceTx = $this->fetchSingleBinanceOrder($apiKey, $apiSecret, $orderIdInput);
        if (!$binanceTx) {
            return $this->error(
                'ORDER_NOT_FOUND',
                'Không tìm thấy giao dịch trên Binance. Vui lòng kiểm tra lại Order ID.',
                ['order_id' => $orderIdInput],
                404
            );
        }

        // user đã chuyển tới đúng ID chưa
        $txReceiverId = $binanceTx['receiverInfo']['binanceId']
            ?? $binanceTx['counterpartyId']
            ?? $binanceTx['uid']
            ?? null;

        if ($txReceiverId && (string)$txReceiverId !== (string)$binanceId) {
            return $this->error('WRONG_PAYEE', 'Giao dịch không chuyển tới đúng Binance ID.', [
                'expected' => $binanceId,
                'actual'   => $txReceiverId,
            ]);
        }

        // amount thực
        $binanceAmount = isset($binanceTx['amount']) ? (float)$binanceTx['amount'] : 0.0;
        $binanceAsset  = strtoupper($binanceTx['currency'] ?? 'USDT');

        // cho lệch 0.01
        if (abs($binanceAmount - $clientAmount) > 0.01) {
            return $this->error('AMOUNT_MISMATCH', 'Số tiền không khớp.', [
                'input_amount'   => $clientAmount,
                'binance_amount' => $binanceAmount,
                'asset'          => $binanceAsset,
            ]);
        }

        // quy -> VND
        $amountVND = $this->mapBinanceAmountToVND($binanceAmount, $binanceAsset);
        if ($amountVND <= 0) {
            return $this->error('CONVERT_FAILED', 'Không thể quy đổi số tiền từ Binance.');
        }

        // VND -> USD
        $currencyVND     = Currency::where('code', 'VND')->first();
        $exchangeRateVND = $currencyVND->exchange_rate ?? 26000;
        $incrementUSD    = $amountVND / $exchangeRateVND;

        $checkoutCompleted = DB::transaction(function () use ($user, $orderIdInput, $binanceMethod, $amountVND, $exchangeRateVND, $binanceAmount, $binanceAsset, $incrementUSD, $checkoutId) {
            $checkout = $checkoutId
                ? Transaction::where('id', $checkoutId)
                    ->where('user_id', $user->id)
                    ->where('type', 'deposit')
                    ->where('status', 'pending')
                    ->lockForUpdate()
                    ->first()
                : null;

            if ($checkoutId && !$checkout) {
                return false;
            }

            // Tính bonus dựa trên số tiền VND
            $bonusData = $this->calculateBonus($amountVND, $binanceMethod->bonus);
            $bonusAmountVND = $bonusData['bonus_amount'];
            $bonusAmountUSD = $bonusAmountVND / $exchangeRateVND;

            $before = $user->balance;
            $user->balance       = $user->balance + $incrementUSD + $bonusAmountUSD;
            $user->total_deposit = $user->total_deposit + $incrementUSD;
            $user->save();

            // Tạo Payment record
            Payment::create([
                'user_id'           => $user->id,
                'payment_method_id' => $binanceMethod->id,
                'transaction_id'    => $orderIdInput,
                'amount'            => $amountVND,
                'bonus_amount'      => $bonusAmountVND,
                'total_amount'      => $amountVND + $bonusAmountVND,
                'currency'          => 'VND',
                'exchange_rate'     => $exchangeRateVND,
                'status'            => 'completed',
                'note'              => "Nạp nội bộ Binance (#{$orderIdInput}) {$binanceAmount} {$binanceAsset}",
                'payment_info'      => [
                    'binance_order_id' => $orderIdInput,
                    'binance_amount'   => $binanceAmount,
                    'binance_asset'    => $binanceAsset,
                    'type'             => 'binance_intern',
                ],
                'domain'            => getDomain(),
            ]);

            // Tạo Transaction record
            if ($checkout) {
                $checkout->update([
                    'amount' => $incrementUSD + $bonusAmountUSD,
                    'type' => 'deposit',
                    'status' => 'completed',
                    'payment_method' => $binanceMethod->name,
                    'transaction_id' => 'BINANCE_' . $orderIdInput,
                    'description' => "Nạp nội bộ Binance (#{$orderIdInput}) {$binanceAmount} {$binanceAsset}",
                    'balance_after' => $user->balance,
                    'domain' => getDomain(),
                ]);
            } else {
                Transaction::create([
                'user_id'          => $user->id,
                'transaction_code' => 'BINANCE_' . $orderIdInput,
                'type'             => 'add',
                'balance_before'   => $before,
                'balance_after'    => $user->balance,
                'amount'           => $incrementUSD + $bonusAmountUSD,
                'description'      => "Nạp nội bộ Binance (#{$orderIdInput}) {$binanceAmount} {$binanceAsset}",
                'status'           => 'success',
                'domain'           => getDomain(),
                ]);
            }
            return true;
        });

        if (!$checkoutCompleted) {
            return response()->json([
                'success' => false,
                'message' => 'Checkout đã được xử lý hoặc không còn hợp lệ.'
            ], 409);
        }

        // Affiliate commission
        \App\Services\AffiliateService::handleDeposit($user->id, $incrementUSD, 'BINANCE_INTERN_' . $orderIdInput);

        return response()->json([
            'success'  => true,
            'message'  => 'Cron job status order completed',
            'reload'   => true,
            'order_id' => $orderIdInput,
        ], 200);
    }

    protected function fetchSingleBinanceOrder(string $apiKey, string $apiSecret, string $orderId, int $daysBack = 1): ?array
    {
        $endpoint = 'https://api.binance.com/sapi/v1/pay/transactions';
        $nowMs    = (int) (microtime(true) * 1000);
        $startMs  = $nowMs - ($daysBack * 24 * 60 * 60 * 1000);

        $params = [
            'transactionType' => 1,
            'startTime'       => $startMs,
            'endTime'         => $nowMs,
            'limit'           => 100,
            'recvWindow'      => 5000,
            'timestamp'       => $nowMs,
        ];

        ksort($params);
        $query     = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $signature = hash_hmac('sha256', $query, $apiSecret);
        $url       = $endpoint . '?' . $query . '&signature=' . $signature;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_HTTPHEADER     => ['X-MBX-APIKEY: ' . $apiKey],
        ]);
        $raw = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            return null;
        }

        $res = json_decode($raw, true);
        if (!is_array($res) || !isset($res['data']) || !is_array($res['data'])) {
            return null;
        }

        foreach ($res['data'] as $item) {
            $itemOrderId = (string)($item['orderId'] ?? '');
            $itemTxnId   = (string)($item['transactionId'] ?? '');
            if ($itemOrderId === (string)$orderId || $itemTxnId === (string)$orderId) {
                return $item;
            }
        }

        return null;
    }

    protected function mapBinanceAmountToVND(float $amount, string $currency): int
    {
        if ($amount <= 0) return 0;

        if ($currency === 'VND') {
            return (int) round($amount);
        }

        $stable = ['USDT', 'BUSD', 'USDC'];
        if (in_array($currency, $stable, true)) {
            $rate = (float) (Currency::where('code', 'VND')->value('exchange_rate') ?? 28000);
            return (int) round($amount * $rate);
        }

        return 0;
    }

    protected function calculateBonus(float $amount, ?string $bonusJson): array
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

            // Tìm tier phù hợp với số tiền (lấy tier cao nhất mà amount >= min)
            foreach ($bonusTiers as $tier) {
                if (isset($tier['min'], $tier['percent']) && $amount >= $tier['min']) {
                    $bonusPercent = $tier['percent'];
                }
            }

            // Tính bonus amount
            if ($bonusPercent > 0) {
                $bonusAmount = ($amount * $bonusPercent) / 100;
            }

            return [
                'bonus_amount' => $bonusAmount,
                'bonus_percent' => $bonusPercent,
            ];
        } catch (\Exception $e) {
            return ['bonus_amount' => 0, 'bonus_percent' => 0];
        }
    }

    protected function error(string $code, string $message, array $extra = [], int $status = 400)
    {
        return response()->json(array_merge([
            'success'    => false,
            'error_code' => $code,
            'message'    => $message,
        ], $extra), $status);
    }
}
