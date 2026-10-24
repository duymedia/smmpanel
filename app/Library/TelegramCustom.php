<?php

namespace App\Library;

use App\Models\Config;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramCustom
{
    private const API = 'https://api.telegram.org';

    public static function notifyManualOrder(Order $order, ?User $user = null, ?Service $service = null): bool
    {
        $user    ??= $order->user;
        $service ??= $order->service;
        $link    = (string) ($order->link ?? '-');
        $link    = mb_strlen($link) > 60 ? mb_substr($link, 0, 60) . '…' : $link;

        return self::send('telegram_notify_manual_order', 'private', '🛒 Đơn hàng thủ công mới', [
            'Mã đơn'     => '<code>#' . $order->id . '</code>',
            'Khách'      => '<b>' . self::esc($user->username ?? $user->email ?? ('#' . $user->id)) . '</b>',
            'Dịch vụ'    => self::serviceName($service, $user),
            'Link'       => self::esc($link),
            'Số lượng'   => '<b>' . number_format((int) $order->quantity) . '</b>',
            'Thành tiền' => '<b>$' . number_format((float) $order->total, 4) . '</b>',
            'Thời gian'  => now()->format('d/m/Y H:i'),
        ]);
    }

    /** Khung sẵn — sẽ ráp dữ liệu khi tích hợp luồng nạp tiền. */
    public static function notifyDeposit(array $p = []): bool
    {
        return self::send('telegram_notify_deposit', 'private', '💰 Giao dịch nạp tiền mới', [
            'Mã giao dịch' => $p['transaction_id'] ?? '-',
            'Khách'        => $p['user']           ?? '-',
            'Số tiền'      => $p['amount']         ?? '-',
            'Phương thức'  => $p['method']         ?? '-',
            'Trạng thái'   => $p['status']         ?? '-',
            'Thời gian'    => now()->format('d/m/Y H:i'),
        ]);
    }

    public static function notifyAddService(Service $service): bool
    {
        return self::send('telegram_notify_add_service', 'public', '✨ Dịch vụ mới', [
            'Mã'        => '<code>#' . $service->id . '</code>',
            'Tên'       => self::serviceName($service),
            'Loại'      => self::esc((string) ($service->type_service ?: ($service->type ?? '-'))),
            'Giá'       => '$' . number_format((float) ($service->rate_retail ?? 0), 4) . ' / 1000',
            'Min - Max' => number_format((int) ($service->min ?? 0)) . ' - ' . number_format((int) ($service->max ?? 0)),
            'Thời gian' => now()->format('d/m/Y H:i'),
        ]);
    }

    /** @param array<string, array{0:mixed,1:mixed}> $changes  ['field' => [old, new]] */
    public static function notifyUpdateService(Service $service, array $changes = []): bool
    {
        $rows = [
            'Mã'  => '<code>#' . $service->id . '</code>',
            'Tên' => self::serviceName($service),
        ];
        if ($changes) {
            $diff = [];
            foreach ($changes as $field => [$old, $new]) {
                $diff[] = '• <b>' . self::esc((string) $field) . '</b>: <s>'
                       . self::esc((string) $old) . '</s> → ' . self::esc((string) $new);
            }
            $rows['Thay đổi'] = "\n" . implode("\n", $diff);
        }
        $rows['Thời gian'] = now()->format('d/m/Y H:i');

        return self::send('telegram_notify_update_service', 'public', '🔄 Cập nhật dịch vụ', $rows);
    }

    /**
     * Core: load config, validate flags, build HTML, POST tới Telegram.
     * `$channel` = 'public' | 'private'.
     */
    public static function send(string $flag, string $channel, string $title, array $rows): bool
    {
        try {
            $c       = Config::where('domain', getDomain())->first();
            $chatKey = $channel === 'public' ? 'telegram_public_chat_id' : 'telegram_private_chat_id';

            if (!$c
                || (int) ($c->telegram_status ?? 0) !== 1
                || (int) ($c->{$flag} ?? 0) !== 1
                || empty($c->telegram_token_bot)
                || empty($c->{$chatKey})
            ) {
                return false;
            }

            $text = "<b>{$title}</b>\n━━━━━━━━━━━━━━━\n";
            foreach ($rows as $k => $v) {
                if ($v === null || $v === '') continue;
                $text .= "▸ <b>{$k}:</b> {$v}\n";
            }

            $res = Http::timeout(10)->asForm()
                ->post(self::API . "/bot{$c->telegram_token_bot}/sendMessage", [
                    'chat_id'                  => $c->{$chatKey},
                    'text'                     => rtrim($text),
                    'parse_mode'               => 'HTML',
                    'disable_web_page_preview' => true,
                ]);

            return $res->successful() && $res->json('ok') === true;
        } catch (\Throwable $e) {
            Log::warning('Telegram notify failed: ' . $e->getMessage());
            return false;
        }
    }

    private static function esc(string $s): string
    {
        return htmlspecialchars($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    private static function serviceName(?Service $service, ?User $user = null): string
    {
        if (!$service) return '-';
        $name = $service->name;
        $lang = $user->lang ?? 'en';
        if (is_array($name)) {
            $name = $name[$lang] ?? $name['en'] ?? reset($name);
        } elseif (is_string($name) && str_starts_with(trim($name), '{')) {
            $parsed = json_decode($name, true);
            if (is_array($parsed)) $name = $parsed[$lang] ?? $parsed['en'] ?? $name;
        }
        return self::esc((string) $name);
    }
}
