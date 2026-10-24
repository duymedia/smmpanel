<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\Config;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AffiliateService
{
 
    public static function handleDeposit(int $depositUserId, float $depositAmount, string $transactionId): void
    {
        try {
            $config = Config::where('domain', getDomain())->first() ?? Config::first();

            // 1. Kiểm tra affiliate_status
            if (!$config || !$config->affiliate_status) {
                Log::info('[Affiliate] Bỏ qua: affiliate_status chưa bật', ['user_id' => $depositUserId]);
                return;
            }

            // 2. Tìm bản ghi affiliate
            $affiliate = Affiliate::where('referred_id', $depositUserId)
                ->where('status', 'active')
                ->first();

            if (!$affiliate) {
                Log::info('[Affiliate] Bỏ qua: không tìm thấy affiliate active cho user #' . $depositUserId);
                return;
            }

            // 3. Tránh duplicate
            $commissionTxnId = 'AFFILIATE-' . $transactionId . '-' . $depositUserId;
            if (Payment::where('transaction_id', $commissionTxnId)->exists()) {
                Log::info('[Affiliate] Bỏ qua: đã xử lý trước đó', ['txn' => $commissionTxnId]);
                return;
            }

            // 4. Lấy rate từ config (affiliate_percent)
            $rate = (float) ($config->affiliate_percent ?? 0);
            if ($rate <= 0) {
                Log::info('[Affiliate] Bỏ qua: affiliate_percent = 0');
                return;
            }

            // 5. Kiểm tra min/max — giới hạn số tiền nạp (depositAmount) được hưởng hoa hồng
            //    Nếu cả hai = 0 thì không giới hạn
            $affiliateMin = (float) ($config->affiliate_min ?? 0);
            $affiliateMax = (float) ($config->affiliate_max ?? 0);

            if ($affiliateMin > 0 && $depositAmount < $affiliateMin) {
                Log::info('[Affiliate] Bỏ qua: số tiền nạp ' . $depositAmount . ' < affiliate_min ' . $affiliateMin, [
                    'user_id' => $depositUserId,
                ]);
                return;
            }

            if ($affiliateMax > 0 && $depositAmount > $affiliateMax) {
                Log::info('[Affiliate] Bỏ qua: số tiền nạp ' . $depositAmount . ' > affiliate_max ' . $affiliateMax, [
                    'user_id' => $depositUserId,
                ]);
                return;
            }

            // 6. Tính commission = depositAmount * rate / 100
            $commission = round($depositAmount * ($rate / 100), 4);

            // 7. Tìm referrer
            $referrer = User::find($affiliate->referrer_id);
            if (!$referrer) {
                Log::warning('[Affiliate] Không tìm thấy referrer #' . $affiliate->referrer_id);
                return;
            }

            // 8. Thực hiện trong transaction
            DB::transaction(function () use ($affiliate, $referrer, $commission, $rate, $depositUserId, $depositAmount, $commissionTxnId) {
                // Cập nhật commission_rate theo config nếu chưa có
                if ((float) $affiliate->commission_rate !== $rate) {
                    $affiliate->update(['commission_rate' => $rate]);
                }

                // Cộng hoa hồng vào balance referrer
                $referrer->increment('balance', $commission);

                // Payment method
                $affiliateMethod = PaymentMethod::firstOrCreate(
                    ['name' => 'Affiliate Commission', 'type' => 'other'],
                    ['image' => null, 'position' => PaymentMethod::getNextPosition(), 'status' => true, 'domain' => getDomain()]
                );

                // Lưu payment record cho referrer
                Payment::create([
                    'user_id'           => $referrer->id,
                    'payment_method_id' => $affiliateMethod->id,
                    'transaction_id'    => $commissionTxnId,
                    'amount'            => $commission,
                    'bonus_amount'      => 0,
                    'total_amount'      => $commission,
                    'currency'          => 'USD',
                    'exchange_rate'     => 1,
                    'status'            => 'completed',
                    'note'              => "Hoa hồng {$rate}% từ user #{$depositUserId} nạp \${$depositAmount}",
                    'payment_info'      => json_encode([
                        'type'               => 'affiliate',
                        'commission_rate'    => $rate,
                        'referred_user_id'   => $depositUserId,
                        'deposit_amount'     => $depositAmount,
                        'source_transaction' => $commissionTxnId,
                    ]),
                    'domain' => getDomain(),
                ]);

                // Cập nhật thống kê affiliate
                $affiliate->increment('total_earned', $commission);   // tổng hoa hồng đã nhận
                $affiliate->increment('total_orders', $depositAmount); // tổng tiền nạp của referred
                $affiliate->increment('orders_count');
                $affiliate->update(['last_order_at' => now()]);
            });

            $affiliate->refresh();
            $referrer->refresh();

            Log::info('=== AFFILIATE COMMISSION PROCESSED ===', [
                'referred_user' => [
                    'id'             => $depositUserId,
                    'deposit_amount' => $depositAmount,
                    'total_deposited'=> $affiliate->total_orders,
                ],
                'commission' => [
                    'rate'       => "{$rate}%",
                    'calculated' => "{$rate}% of {$depositAmount} = {$commission}",
                    'deposit_range' => "min={$config->affiliate_min}, max={$config->affiliate_max} (0 = không giới hạn)",
                ],
                'referrer' => [
                    'id'                  => $referrer->id,
                    'username'            => $referrer->username,
                    'earned_this_time'    => $commission,
                    'total_earned'        => $affiliate->total_earned,
                    'new_balance'         => $referrer->balance,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('[Affiliate] handleDeposit error: ' . $e->getMessage(), [
                'deposit_user_id' => $depositUserId,
                'deposit_amount'  => $depositAmount,
                'transaction_id'  => $transactionId,
            ]);
        }
    }
}
