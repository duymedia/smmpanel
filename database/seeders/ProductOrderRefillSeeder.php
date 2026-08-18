<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductOrderRefillSeeder extends Seeder
{
    public function run(): void
    {
        $users    = DB::table('users')->pluck('id')->toArray();
        $products = DB::table('products')->pluck('id')->toArray();

        if (empty($users) || empty($products)) {
            $this->command->warn('Cần có users và products trước. Chạy ProductSeeder trước.');
            return;
        }

        $orderStatuses   = ['Completed', 'Completed', 'Completed', 'Partial', 'Canceled'];
        $refillStatuses  = ['Pending', 'Pending', 'In progress', 'Completed', 'Rejected'];
        $domain          = 'localhost';
        $now             = Carbon::now();
        $rows            = [];
        $count           = 0;

        foreach ($products as $productId) {
            $numOrders = rand(8, 15);
            for ($i = 0; $i < $numOrders; $i++) {
                $userId      = $users[array_rand($users)];
                $qty         = rand(1, 10);
                $price       = round(rand(200, 1500) / 100, 4);
                $createdAt   = $now->copy()->subDays(rand(0, 29))->subHours(rand(0, 23));
                $refillStatus = $refillStatuses[array_rand($refillStatuses)];

                $rows[] = [
                    'user_id'                  => $userId,
                    'domain'                   => $domain,
                    'product_id'               => $productId,
                    'provider_product_order_id'=> null,
                    'status'                   => $orderStatuses[array_rand($orderStatuses)],
                    'amount'                   => $price * $qty,
                    'charge'                   => round($price * $qty * 1.1, 4),
                    'quantity'                 => $qty,
                    'note'                     => null,
                    'refill'                   => true,
                    'refill_status'            => $refillStatus,
                    'created_at'               => $createdAt->toDateTimeString(),
                    'updated_at'               => $createdAt->copy()->addMinutes(rand(5, 120))->toDateTimeString(),
                ];
                $count++;
            }
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('product_orders')->insert($chunk);
        }

        $this->command->info("Đã tạo $count product orders có refill cho " . count($products) . " products.");
    }
}
