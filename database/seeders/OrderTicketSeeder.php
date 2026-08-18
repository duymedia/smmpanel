<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderTicketSeeder extends Seeder
{
    public function run(): void
    {
        $users    = DB::table('users')->pluck('id')->toArray();
        $services = DB::table('services')->pluck('id')->toArray();

        if (empty($users) || empty($services)) {
            $this->command->warn('Cần có users và services trước.');
            return;
        }

        // Tắt strict mode để tránh lỗi ENUM truncation
        DB::statement("SET SESSION sql_mode = ''");

        $ticketPool = [
            'cancel', 'cancel_request', 'cancel-order', 'request_cancel',
            'refill', 'refill_request', 'refill-warranty', 'request_refill',
            'speedup', 'speed_up', 'speed-up', 'request_speedup', 'speedup_request',
        ];

        // Chỉ dùng giá trị hợp lệ của ENUM + NULL
        $ticketStatuses = [null, null, null, 'processing', 'processing', 'completed'];
        $orderStatuses  = ['pending', 'processing', 'in_progress', 'completed', 'partial', 'failed', 'canceled'];

        $links = [
            'https://www.facebook.com/profile.php?id=',
            'https://www.tiktok.com/@user',
            'https://www.instagram.com/p/',
            'https://www.youtube.com/watch?v=',
            'https://twitter.com/user/status/',
        ];

        $rows  = [];
        $count = 0;
        $now   = Carbon::now();

        foreach ($services as $serviceId) {
            $numTickets = rand(20, 40);
            for ($i = 0; $i < $numTickets; $i++) {
                $userId        = $users[array_rand($users)];
                $ticket        = $ticketPool[array_rand($ticketPool)];
                $ticketStatus  = $ticketStatuses[array_rand($ticketStatuses)];
                $createdAt     = $now->copy()
                    ->subDays(rand(0, 29))
                    ->subHours(rand(0, 23))
                    ->subMinutes(rand(0, 59));

                $rows[] = [
                    'user_id'       => $userId,
                    'service_id'    => $serviceId,
                    'link'          => $links[array_rand($links)] . rand(10000, 99999),
                    'quantity'      => rand(100, 50000),
                    'rate'          => round(rand(1, 100) / 1000, 8),
                    'charge'        => round(rand(10, 500) / 100, 8),
                    'total'         => round(rand(10, 500) / 100, 8),
                    'start_count'   => rand(0, 10000),
                    'remains'       => rand(0, 2000),
                    'provider_name' => 'smmcoder.com',
                    'provider_id'   => (string) rand(1, 5),
                    'type'          => 'default',
                    'currency'      => 'USD',
                    'refill'        => 0,
                    'cancel'        => 0,
                    'dripfeed'      => 0,
                    'ticket'        => $ticket,
                    'ticket_status' => $ticketStatus,
                    'status'        => $orderStatuses[array_rand($orderStatuses)],
                    'note'          => null,
                    'created_at'    => $createdAt->toDateTimeString(),
                    'updated_at'    => $createdAt->copy()->addMinutes(rand(1, 120))->toDateTimeString(),
                    'domain'        => 'localhost',
                ];
                $count++;
            }
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('orders')->insert($chunk);
        }

        $this->command->info("Đã tạo $count orders có ticket cho " . count($services) . " services.");
    }
}
