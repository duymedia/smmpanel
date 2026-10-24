<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\Category;
use App\Models\Config;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Platform;
use App\Models\Service;
use App\Models\ChildPanel;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\TicketSubject;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Payment;
use App\Models\Event;
use App\Models\EventSpin;
use App\Models\User;
use App\Library\TelegramCustom;
use App\Smm\Smm;
use App\Jobs\ProcessStagedOrdersJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DataController extends Controller
{
    public function spin(Request $request, Event $event): JsonResponse
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập'], 401);
        }

        if ($event->domain !== $request->getHost()) {
            return response()->json(['success' => false, 'message' => 'Sự kiện không tồn tại'], 404);
        }

        if (!$event->isActive()) {
            return response()->json(['success' => false, 'message' => 'Sự kiện đã kết thúc'], 400);
        }

        if (!$event->canUserSpin($user->id)) {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt hôm nay'], 400);
        }

        try {
            return DB::transaction(function () use ($event, $user, $request): JsonResponse {
                $reward = $this->randomEventReward($event->rewards);
                $code = $user->currency ?? 'VND';
                $currency = Currency::where('code', $code)->first();
                $rate = (float) ($currency?->exchange_rate ?: 1);

                EventSpin::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'reward_name' => $reward['name'],
                    'reward_amount' => $reward['amount'],
                    'ip_address' => $request->ip(),
                ]);

                if ($reward['amount'] > 0) {
                    $user->increment('balance', $reward['amount']);
                }

                return response()->json([
                    'success' => true,
                    'reward' => $reward,
                    'displayAmount' => round($reward['amount'] * $rate, 2),
                    'currency' => [
                        'code' => $code,
                        'symbol' => $currency?->symbol ?: '$',
                        'symbol_position' => $currency?->symbol_position ?: 'before',
                        'exchange_rate' => $rate,
                    ],
                ]);
            });
        } catch (\Throwable) {
            return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra'], 500);
        }
    }

    private function randomEventReward(array $rewards): array
    {
        $total = array_sum(array_column($rewards, 'probability'));
        $random = mt_rand(1, max(1, (int) ($total * 100))) / 100;
        $current = 0;

        foreach ($rewards as $reward) {
            $current += $reward['probability'];
            if ($random <= $current) {
                return $reward;
            }
        }

        return end($rewards) ?: ['name' => '', 'amount' => 0];
    }
    public function paymentHistory(Request $request): JsonResponse
    {
        $bonusIcon = 'https://i.imgur.com/vc5lCtW.png';

        $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
        ]);

        $payments = Payment::query()
            ->where('user_id', Auth::id())
            ->where('domain', getDomain())
            ->whereBetween('created_at', [$request->input('start'), $request->input('end')])
            ->with('paymentMethod')
            ->latest()
            ->get();

        $history = $payments->flatMap(function (Payment $payment) use ($bonusIcon): array {
            $method = $payment->paymentMethod;
            $details = $payment->transaction_id ?: ($payment->note ?? '');
            $row = [
                'pmethod' => $method?->name ?? 'N/A',
                'amount' => (float) $payment->amount,
                'custom_icon' => $method?->image ?? '',
                'icon' => $method?->image ?? '',
                'fund_id' => $payment->id,
                'details' => e($details),
                'created' => $payment->created_at?->format('Y-m-d H:i:s') ?? '',
            ];

            $rows = [$row];
            if ((float) $payment->bonus_amount > 0) {
                $rows[] = [
                    'pmethod' => 'Bonus',
                    'amount' => (float) $payment->bonus_amount,
                    'custom_icon' => $bonusIcon,
                    'icon' => $bonusIcon,
                    'fund_id' => null,
                    'details' => 'Payment Bonus',
                    'created' => $payment->created_at?->format('Y-m-d H:i:s') ?? '',
                ];
            }

            return $rows;
        })->values();

        return response()->json(['history' => $history]);
    }

    public function getPaymentInvoice(Request $request): JsonResponse
    {
        $payment = Payment::query()
            ->whereKey($request->integer('fund_id'))
            ->where('user_id', Auth::id())
            ->where('domain', getDomain())
            ->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment does not exist']);
        }

        return response()->json([
            'invoice_url' => route('clients.addfunds.invoice', $payment->id),
        ]);
    }

    public function confirmService(Request $request): JsonResponse
    {
        $config = Config::where('domain', getDomain())->first();
        if (!serviceOn($config, 'require_confirm_service')) {
            return response()->json([
                'error' => 'Service price confirmation is currently disabled.',
            ], 403);
        }

        $exists = Service::where('domain', getDomain())
            ->where('status', true)
            ->whereKey((int) $request->input('service_id'))
            ->exists();

        return $exists
            ? response()->json(['success' => 'Service rate confirmed'])
            : response()->json(['error' => 'Service does not exist']);
    }

    public function checkCoupon(Request $request): JsonResponse
    {
        $coupon = Coupon::where('domain', getDomain())
            ->where('code', trim((string) $request->input('coupon')))
            ->first();

        if (!$coupon || !$coupon->is_active) {
            return response()->json(['error' => 'Coupon is invalid or expired']);
        }

        return response()->json([
            'success' => 'Coupon is valid',
            'discount_type' => $coupon->discount_type,
            'discount_value' => (float) $coupon->discount_value,
        ]);
    }

    public function getFacebookId(Request $request): JsonResponse
    {
        $link = trim((string) $request->input('link'));
        preg_match('/(?:id=|facebook\.com\/)(\d+)/i', $link, $match);

        return isset($match[1])
            ? response()->json(['success' => $match[1]])
            : response()->json(['error' => 'Unable to extract Facebook ID']);
    }

    /**
     * Check if API error is in keep_orders list
     */
    private function isErrorInKeepOrders($apiError): bool
    {
        $config = Config::where('domain', getDomain())->first();
        if (!$config) return false;

        $keepOrders = $config->getKeepOrders();
        if (empty($keepOrders)) return false;

        foreach ($keepOrders as $keepError) {
            if (stripos($apiError, $keepError) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Bump orders table AUTO_INCREMENT by a random step if fake_order_status is enabled.
     */
    private function applyFakeOrderId(int $lastOrderId): void
    {
        $config = Config::where('domain', getDomain())
            ->select('fake_order_status', 'fake_order_step_min', 'fake_order_step_max')
            ->first();

        if (!$config || !$config->fake_order_status) return;

        $min  = max(1, (int) ($config->fake_order_step_min ?? 1));
        $max  = max($min, (int) ($config->fake_order_step_max ?? 100));
        $next = $lastOrderId + rand($min, $max);

        DB::statement("ALTER TABLE orders AUTO_INCREMENT = {$next}");
    }

    public function createOrder(Request $request): JsonResponse
    {
        try {
            $request->merge(array_filter([
                'service' => $request->input('service', $request->input('sid')),
                'mediaUrl' => $request->input('mediaUrl', $request->input('media')),
            ], static fn ($value) => $value !== null && $value !== ''));

            $service = Service::where('domain', getDomain())
                ->find($request->service);
            if (!$service) {
                return response()->json([
                    'status' => 'error',
                    'success' => false,
                    'message' => 'Service does not exist'
                ], 422);
            }

            $user = Auth::user();
            if (!$user) {
                return response()->json(['status' => 'error', 'success' => false, 'message' => 'Unauthenticated'], 401);
            }

            $locale = strtolower((string) ($request->input('lang')
                ?: $request->header('X-Language')
                ?: $user->lang
                ?: app()->getLocale()));
            $successMessage = str_starts_with($locale, 'vi')
                ? 'Đặt hàng thành công' : 'Order successfully';

            $serviceType = $service->type_service ?? 'Default';

            if ($service->advanced_settings) {
                $settings = $service->advanced_settings_data ?? [];
                $minimumBalance = (float) ($settings['min_balance'] ?? 0);
                $maximumOrder = (int) ($settings['max_order'] ?? 0);
                if ($minimumBalance > 0 && (float) $user->balance < $minimumBalance) {
                    return response()->json(['status' => 'error', 'success' => false, 'message' => 'Your balance is below the minimum required'], 422);
                }
                if ($maximumOrder > 0 && Order::where('user_id', $user->id)->where('service_id', $service->id)
                    ->whereNotIn('status', ['completed', 'canceled', 'failed'])->count() >= $maximumOrder) {
                    return response()->json(['status' => 'error', 'success' => false, 'message' => 'Maximum active orders for this service reached'], 422);
                }
            }

            $rules = [
                'service' => 'required|exists:services,id',
                'check' => 'nullable|boolean',
            ];

            $messages = [
                'service.required' => 'Please select a service',
                'service.exists' => 'Service does not exist',
            ];

            switch ($serviceType) {
                case 'Custom Comments':
                    $rules['link'] = 'required|string';
                    $rules['comments'] = 'required|string';
                    $rules['quantity'] = 'nullable|integer|min:1';
                    $messages['link.required'] = 'Please enter a link';
                    $messages['comments.required'] = 'Please enter comments';
                    break;

                case 'Package':
                    $rules['link'] = 'required|string';
                    $messages['link.required'] = 'Please enter a link';
                    break;

                case 'Subscriptions':
                    $rules['username'] = 'required|string';
                    $rules['min'] = 'required|integer|min:1';
                    $rules['max'] = 'required|integer|min:1';
                    $rules['delay'] = 'required|integer|min:0';
                    $rules['posts'] = 'nullable|integer|min:0';
                    $rules['old_posts'] = 'nullable|integer|min:0';
                    $rules['expiry'] = 'nullable|date';
                    $messages['username.required'] = 'Please enter username';
                    $messages['min.required'] = 'Please enter minimum quantity';
                    $messages['max.required'] = 'Please enter maximum quantity';
                    $messages['delay.required'] = 'Please enter delay';
                    break;

                case 'Default':
                default:
                    $rules['link'] = 'required|string';
                    $rules['quantity'] = 'required|integer|min:1';
                    $rules['runs'] = 'nullable|integer|min:1';
                    $rules['interval'] = 'nullable|integer|min:1';
                    $rules['delay'] = 'nullable|integer|min:0';
                    $messages['link.required'] = 'Please enter a link';
                    $messages['quantity.required'] = 'Please enter quantity';
                    $messages['quantity.integer'] = 'Quantity must be a number';
                    $messages['quantity.min'] = 'Quantity must be greater than 0';
                    break;
            }

            $rules = array_merge($rules, [
                'expiry' => 'nullable|date',
                'username' => 'nullable|string',
                'keywords' => 'nullable|string',
                'comments' => 'nullable|string',
                'hashtag' => 'nullable|string',
                'hashtags' => 'nullable|string',
                'usernames' => 'nullable|string',
                'mediaUrl' => 'nullable|url',
                'posts' => 'nullable|integer',
                'old_posts' => 'nullable|integer',
                'min' => 'nullable|integer',
                'max' => 'nullable|integer',
                'country' => 'nullable|string|max:2',
                'device' => 'nullable|integer|between:1,5',
                'type_of_traffic' => 'nullable|integer|between:1,3',
                'google_keyword' => 'nullable|string',
                'referring_url' => 'nullable|url',
                'loop_quantity' => 'nullable|integer|min:1',
                'loop_spacing'  => 'nullable|integer|min:1',
                'schedule_time' => 'nullable|date',
            ]);

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => implode('. ', $validator->errors()->all())
                ], 422);
            }

            $config = Config::where('domain', getDomain())->first();
            if (serviceOn($config, 'check_duplicate_order_status')) {
                $link = $request->link ?? '';
                $duplicateTime = (int) ($config->check_duplicate_order_time ?? 0);

                if ($link && $duplicateTime > 0) {
                    $hasRecent = Order::where('user_id', $user->id)
                        ->where('service_id', $service->id)
                        ->where('link', $link)
                        ->where('domain', getDomain())
                        ->where('created_at', '>=', now()->subSeconds($duplicateTime))
                        ->exists();

                    if ($hasRecent) {
                        return response()->json([
                            'status' => 'error',
                            'success' => false,
                            'message' => 'Your order has been duplicated. Please wait a moment before placing your order again.'
                        ], 422);
                    }
                }
            }

            if ($serviceType === 'Default') {
                if ($request->quantity < $service->min || $request->quantity > $service->max) {
                    return response()->json([
                        'status' => 'error',
                        'success' => false,
                        'message' => "Quantity less than minimal ({$service->min})" . ($request->quantity > $service->max ? " or greater than maximum ({$service->max})" : '')
                    ], 422);
                }
            }

            if ($serviceType === 'Custom Comments') {
                $quantity = $request->quantity ?? 0;
                if ($quantity > 0 && ($quantity < $service->min || $quantity > $service->max)) {
                    return response()->json([
                        'status' => 'error',
                        'success' => false,
                        'message' => "Quantity less than minimal ({$service->min})" . ($quantity > $service->max ? " or greater than maximum ({$service->max})" : '')
                    ], 422);
                }
            }

            if ($serviceType === 'Subscriptions') {
                $min = $request->min ?? $service->min;
                $max = $request->max ?? $service->max;

                if ($min < $service->min || $max > $service->max) {
                    return response()->json([
                        'status' => 'error',
                        'success' => false,
                        'message' => "Min/Max values must be within service limits ({$service->min} - {$service->max})"
                    ], 422);
                }

                if ($min > $max) {
                    return response()->json([
                        'status' => 'error',
                        'success' => false,
                        'message' => "Minimum quantity cannot be greater than maximum quantity"
                    ], 422);
                }
            }

            $rate = getUserServiceRate($user, $service);
            $quantity = 0;

            switch ($serviceType) {
                case 'Package':
                    $quantity = 1;
                    $total = $rate;
                    break;

                case 'Subscriptions':
                    $quantity = $request->max ?? $service->max;
                    $total = ($quantity / 1000) * $rate;
                    break;

                case 'Custom Comments':
                    $quantity = $request->quantity ?? 0;
                    if ($quantity == 0 && $request->filled('comments')) {
                        $comments = trim($request->comments);
                        $lines = $comments ? explode("\n", $comments) : [];
                        $quantity = count(array_filter($lines, fn($line) => trim($line) !== ''));
                    }
                    $total = ($quantity / 1000) * $rate;
                    break;

                case 'Default':
                default:
                    $quantity = $request->quantity;
                    $total = ($quantity / 1000) * $rate;
                    break;
            }

            if ($user->balance < $total) {
                return response()->json([
                    'status' => 'error',
                    'success' => false,
                    'message' => 'Not enough funds'
                ], 422);
            }

            $orderData = [
                'user_id' => $user->id,
                'service_id' => $service->id,
                'link' => $request->link ?? '',
                'comment' => $request->comments ?? null,
                'quantity' => $quantity,
                'rate' => $rate,
                'charge' => $total,
                'total' => $total,
                'start_count' => 0,
                'remains' => $quantity,
                'status' => 'pending',
                'currency' => 'USD',
                'domain' => getDomain(),
                'type' => 'normal',
                'service_api' => $service->service_api ?? null,
                'provider_id' => $service->provider_id ?? null,
                'provider_name' => $service->provider->name ?? null,
                'refill' => $service->refill ?? false,
                'cancel' => $service->cancel ?? false,
                'dripfeed' => $request->boolean('check', false),
                'reaction' => $service->reaction ?? null,
            ];

            if ($orderData['dripfeed'] && $request->filled(['runs', 'interval'])) {
                $orderData['loop_quantity'] = $request->runs;
                $orderData['loop_spacing'] = $request->interval;
            }

            if ($request->filled('loop_quantity')) {
                $orderData['loop_quantity'] = (int) $request->loop_quantity;
            }
            if ($request->filled('loop_spacing')) {
                $orderData['loop_spacing'] = (int) $request->loop_spacing;
            }

            if ($request->filled('schedule_time')) {
                $orderData['schedule_time'] = \Carbon\Carbon::parse($request->schedule_time);
                $orderData['status'] = 'awaiting';
            } elseif ($request->filled('delay') && $request->delay > 0) {
                $orderData['schedule_time'] = now()->addMinutes($request->delay);
            }

            $orderDataArray = [
                'service_name' => $service->name,
                'service_id' => $service->id,
                'service_type' => $serviceType,
                'link' => $request->link ?? '',
                'quantity' => $quantity,
                'rate' => $rate,
                'charge' => $total,
                'total' => $total,
                'dripfeed' => $orderData['dripfeed'],
                'refill' => $orderData['refill'],
                'cancel' => $orderData['cancel'],
                'type' => $orderData['type'],
                'currency' => $orderData['currency'],
            ];

            if ($orderData['dripfeed']) {
                $orderDataArray['loop_quantity'] = $orderData['loop_quantity'] ?? null;
                $orderDataArray['loop_spacing'] = $orderData['loop_spacing'] ?? null;
            }

            if (!empty($orderData['loop_quantity'])) {
                $orderDataArray['loop_quantity'] = $orderData['loop_quantity'];
            }
            if (!empty($orderData['loop_spacing'])) {
                $orderDataArray['loop_spacing'] = $orderData['loop_spacing'];
            }

            if (isset($orderData['schedule_time'])) {
                $orderDataArray['schedule_time'] = $orderData['schedule_time'];
            }

            $additionalFields = ['expiry', 'username', 'keywords', 'comments', 'hashtag', 'hashtags', 'usernames', 'mediaUrl', 'posts', 'old_posts', 'min', 'max', 'delay', 'country', 'device', 'type_of_traffic', 'google_keyword', 'referring_url'];
            foreach ($additionalFields as $field) {
                if ($request->filled($field)) {
                    $orderDataArray[$field] = $request->input($field);
                }
            }

            $orderData['order_data'] = json_encode(array_filter($orderDataArray), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $isScheduledOrder = ($orderData['status'] ?? null) === 'awaiting';

            $orderData['status'] = 'awaiting';

            DB::transaction(function () use ($orderData, $user, $total, &$order) {
                $order = Order::create($orderData);
                $user->decrement('balance', $total);

                $totalStr     = number_format((float)$total, 9, '.', '');
                $balanceStr   = number_format((float)$user->balance, 9, '.', '');
                $balanceAfter = bcsub($balanceStr, $totalStr, 9);
                Transaction::create([
                    'user_id'        => $user->id,
                    'order_id'       => $order->id,
                    'amount'         => -$total,
                    'type'           => 'order',
                    'status'         => 'completed',
                    'payment_method' => 'balance',
                    'transaction_id' => 'ORDER-' . $order->id,
                    'description'    => 'Order #' . $order->id . ' - Service #' . $order->service_id,
                    'balance_after'  => $balanceAfter,
                    'domain'         => getDomain(),
                ]);
            });

            $provider = $service->provider;
            if ($isScheduledOrder) {
            } elseif (!$provider || !$provider->status) {
                $order->update(['status' => 'pending']);
            } else {
                try {
                    // Execute immediately; no queue worker or RabbitMQ consumer is required.
                    ProcessStagedOrdersJob::dispatch($order->id, $order->domain)
                        ->delay(now()->addSeconds(3));
                } catch (\Throwable $exception) {
                    Log::error('Order processing failed', [
                        'order_id' => $order->id,
                        'domain' => $order->domain,
                        'error' => $exception->getMessage(),
                    ]);
                }
            }

            $this->applyFakeOrderId($order->id);

            $user->refresh();

            $serviceName = $service->name;
            if (is_string($serviceName)) {
                $parsed = json_decode($serviceName, true);
                $serviceName = $parsed[$user->lang ?? 'en'] ?? $parsed['en'] ?? $serviceName;
            } elseif (is_array($serviceName)) {
                $serviceName = $serviceName[$user->lang ?? 'en'] ?? $serviceName['en'] ?? reset($serviceName);
            }

            if (($service->type ?? null) === 'manual') {
                TelegramCustom::notifyManualOrder($order, $user, $service);
            }

            $userCurrency = Currency::where('code', $user->currency ?? 'USD')
                ->where('status', true)->first();
            $userCurrency ??= (object) [
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'before',
                'exchange_rate' => 1,
            ];

            $orderResponse = [
                'id'               => $order->id,
                'service'          => $serviceName,
                'link'             => $order->link,
                'quantity'         => $order->quantity,
                'charge'           => fmtMoney($total, $userCurrency, [], true),
                'original_charge'  => fmtMoney($rate, $userCurrency, [], true),
                'original_balance' => fmtMoney($user->balance + $total, $userCurrency, [], true),
                'balance'          => fmtMoney($user->balance, $userCurrency, [], true),
                'converted'        => false,
                'currency_template' => ($userCurrency->symbol_position ?? 'before') === 'before'
                    ? ($userCurrency->symbol ?? '$') . '{{value}}'
                    : '{{value}}' . ($userCurrency->symbol ?? '$'),
            ];

            if ($serviceType === 'Custom Comments' && $order->comment) {
                $orderResponse['comments'] = $order->comment;
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'success' => 1,
                    'order' => $orderResponse,
                    'url' => '/orders/' . $order->id,
                ],
                'success' => true,
                'message' => $successMessage,
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();

            Log::error('Error creating order: ' . $errorMsg, [
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'exception' => $e
            ]);

            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => $errorMsg
            ], 422);
        }
    }

    public function getCategoriesByPlatform($platformId)
    {
        if ($platformId === 'all') {
            $categories = Category::where('domain', getDomain())
                ->with('platform')
                ->orderBy('position')
                ->get();
        } else {
            $categories = Category::where('platform_id', $platformId)
                ->where('domain', getDomain())
                ->orderBy('position')
                ->get();
        }

        return response()->json($categories->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'image' => ($cat->image && preg_match('/\.(?:png|jpe?g|gif|webp|svg)(?:\?.*)?$/i', (string) $cat->image) === 1)
                    ? asset($cat->image) : null,
            ];
        }));
    }

    public function getServicesByCategory($categoryId)
    {
        $services = Service::where('category_id', $categoryId)
            ->where('domain', getDomain())
            ->where('status', 1)
            ->orderBy('position')
            ->get();

        return response()->json($services->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'rate_formatted' => $service->rate_formatted,
                'min' => $service->min,
                'max' => $service->max,
                'description' => $service->description,
                'note' => $service->note,
                'average_time' => $service->average_time,
                'type_service' => $service->type_service,
                'attributes' => $service->attributes ? json_decode($service->attributes, true) : [],
            ];
        }));
    }

    /**
     * Create new ticket
     */
    public function createTicket(Request $request): JsonResponse
    {
        $rules = [
            'category' => 'required|string',
            'subcategory' => 'nullable|string',
            'message' => 'required|string|max:5000',
            'custom_fields' => 'sometimes|array',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,txt,csv',
        ];

        $messages = [
            'category.required' => 'Vui lòng chọn danh mục',
            'message.required' => 'Vui lòng nhập nội dung',
            'message.max' => 'Nội dung không được quá 5000 ký tự',
            'attachments.*.max' => 'File không được lớn hơn 5MB',
            'attachments.*.mimes' => 'File phải có định dạng: jpg, jpeg, png, gif, pdf, txt, csv',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $category = $request->input('category');
            $subcategory = $request->input('subcategory');

            $ticketSubject = TicketSubject::where('category', $category)
                ->where('subcategory', $subcategory)
                ->first() ?? TicketSubject::where('category', $category)
                ->whereNull('subcategory')
                ->first();

            // Nếu không tìm thấy subject, tạo mới hoặc lấy subject đầu tiên của category
            if (!$ticketSubject) {
                $ticketSubject = TicketSubject::firstOrCreate(
                    ['category' => $category, 'subcategory' => null],
                    ['show_message_only' => false, 'status' => 1, 'sort_order' => 0]
                );
            }

            $subject = $subcategory ? $category . ' - ' . $subcategory : $category;
            $customFields = $request->input('custom_fields', []);

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('ticket-attachments', $fileName, 'public');
                    $attachments[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'file_name' => $fileName,
                        'file_path' => $filePath,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ];
                }
            }

            $ticket = Ticket::create([
                'user_id' => Auth::id(),
                'domain' => getDomain(),
                'subject_id' => $ticketSubject->id,
                'subject' => $subject,
                'message' => $request->input('message'),
                'custom_fields' => $customFields,
                'status' => 'open',
                'priority' => 'medium',
            ]);

            TicketReply::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'message' => $request->input('message'),
                'is_admin' => false,
                'attachments' => $attachments,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ticket đã được tạo thành công.',
                'ticket_id' => $ticket->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating ticket: ' . $e->getMessage() . ' | Line: ' . $e->getLine() . ' | File: ' . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo ticket. Vui lòng thử lại.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Reply to ticket
     */
    public function replyTicket(Request $request, $ticketId): JsonResponse
    {
        $request->validate([
            'TicketMessageForm.message' => 'required|string|max:5000',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,txt,csv',
        ], [
            'TicketMessageForm.message.required' => 'Vui lòng nhập tin nhắn',
            'TicketMessageForm.message.max' => 'Tin nhắn không được quá 5000 ký tự',
            'attachments.*.max' => 'File không được lớn hơn 5MB',
            'attachments.*.mimes' => 'File phải có định dạng: jpg, jpeg, png, gif, pdf, txt, csv',
        ]);

        try {
            $ticket = Auth::user()->tickets()->findOrFail($ticketId);

            if ($ticket->status === 'closed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể trả lời ticket đã đóng.'
                ], 400);
            }

            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('ticket-attachments', $fileName, 'public');
                    $attachments[] = [
                        'original_name' => $file->getClientOriginalName(),
                        'file_name' => $fileName,
                        'file_path' => $filePath,
                        'mime_type' => $file->getMimeType(),
                        'file_size' => $file->getSize(),
                    ];
                }
            }

            DB::transaction(function () use ($ticket, $request, $attachments, &$reply) {
                $reply = TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => Auth::id(),
                    'message' => $request->input('TicketMessageForm.message'),
                    'is_admin' => false,
                    'attachments' => $attachments,
                ]);

                $ticket->update([
                    'status' => 'open',
                    'last_reply_at' => now(),
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Tin nhắn đã được gửi thành công.',
                'reply' => $reply->load('user'),
            ]);
        } catch (\Exception $e) {
            Log::error('Error replying to ticket: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại.'
            ], 500);
        }
    }

    /**
     * Close ticket
     */
    public function closeTicket(Request $request, $ticketId): JsonResponse
    {
        try {
            $ticket = Auth::user()->tickets()->findOrFail($ticketId);

            if ($ticket->status === 'closed') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ticket đã được đóng trước đó.'
                ], 400);
            }

            $ticket->update(['status' => 'closed']);

            return response()->json([
                'success' => true,
                'message' => 'Ticket đã được đóng thành công.',
                'redirect' => route('clients.tickets.index')
            ]);
        } catch (\Exception $e) {
            Log::error('Error closing ticket: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi đóng ticket. Vui lòng thử lại.'
            ], 500);
        }
    }

    /**
     * Get ticket replies
     */
    public function getTicketMessages($ticketId): JsonResponse
    {
        try {
            $ticket = Auth::user()->tickets()->findOrFail($ticketId);

            $replies = $ticket
                ->replies()
                ->with('user')
                ->orderBy('created_at')
                ->get()
                ->map(function ($reply) {
                    return [
                        'id' => $reply->id,
                        'message' => $reply->message,
                        'user' => [
                            'id' => $reply->user->id,
                            'name' => $reply->user->name,
                        ],
                        'is_admin' => $reply->is_admin,
                        'attachments' => $reply->attachments,
                        'created_at' => $reply->created_at->format('H:i'),
                        'created_at_full' => $reply->created_at->toISOString(),
                    ];
                });

            return response()->json([
                'success' => true,
                'replies' => $replies
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting ticket replies: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải tin nhắn.'
            ], 500);
        }
    }

    /**
     * Get subcategories by category
     */
    public function getTicketSubcategories(Request $request): JsonResponse
    {
        $category = $request->get('category');

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category is required'
            ], 400);
        }

        $subcategories = TicketSubject::where('category', $category)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get(['id', 'subcategory', 'show_message_only', 'required_fields']);

        return response()->json([
            'success' => true,
            'subcategories' => $subcategories
        ]);
    }

    /**
     * Get all ticket categories
     */
    public function getTicketCategories(): JsonResponse
    {
        $categories = TicketSubject::where('status', 1)
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }

    /**
     * Update user currency
     */
    public function updateCurrency(Request $request): JsonResponse
    {
        $request->validate([
            'currency_code' => 'required|string|size:3',
            'currency_symbol' => 'required|string|max:10',
            'currency_name' => 'required|string|max:100'
        ]);

        $user = Auth::user();
        $currency = Currency::where('code', strtoupper($request->currency_code))->where('status', 1)->first();

        if (!$currency) {
            return response()->json(['success' => false, 'message' => 'Currency not found'], 400);
        }

        $user->update(['currency' => $currency->code]);

        $balance = $currency->exchange_rate > 0 ? $user->balance / $currency->exchange_rate : $user->balance;
        $decimals = $balance >= 1000 ? 0 : ($balance >= 100 ? 1 : ($balance >= 10 ? 2 : 3));
        $formatted = rtrim(number_format($balance, $decimals), '0.');
        $formattedBalance = $currency->symbol_position === 'before' ? $currency->symbol . $formatted : $formatted . $currency->symbol;

        return response()->json([
            'success' => true,
            'data' => [
                'currency_code' => $currency->code,
                'currency_symbol' => $currency->symbol,
                'currency_name' => $currency->name,
                'symbol_position' => $currency->symbol_position,
                'formatted_balance' => $formattedBalance
            ]
        ]);
    }

    /**
     * Update user language
     */
    public function updateLanguage(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $user->update(['lang' => $request->lang]);

            return response()->json([
                'success' => true,
                'message' => 'Language updated successfully',
                'lang' => $request->lang
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating language: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating language'
            ], 500);
        }
    }

    /**
     * Update user email
     */
    public function updateEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'required|string'
        ]);

        try {
            $user = Auth::user();

            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }

            $user->update(['email' => $request->email]);

            return response()->json([
                'success' => true,
                'message' => 'Email updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating email: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating email'
            ], 500);
        }
    }

    public function updateInformation(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:30',
        ]);

        $user = $request->user();
        $user->update([
            'email' => $data['email'],
            'phone' => trim((string) ($data['phone'] ?? '')),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Information updated successfully',
        ]);
    }

    public function updateName(Request $request): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255']]);
        $user = $request->user();
        $user->name = trim($data['name']);
        // Use the value entered by the customer; do not generate a random code.
        $user->transfer_code = trim($data['name']);
        $user->save();

        return response()->json(['success' => true, 'name' => $user->name, 'transfer_code' => $user->transfer_code]);
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ], [
            'password.confirmed' => 'The password confirmation does not match'
        ]);

        try {
            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect'
                ], 400);
            }

            $user->update(['password' => Hash::make($request->password)]);

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating password: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating password'
            ], 500);
        }
    }

    /**
     * Update user timezone
     */
    public function updateTimezone(Request $request): JsonResponse
    {
        $request->validate([
            'timezone' => 'required|string'
        ]);

        try {
            $user = Auth::user();
            $timezone = $request->timezone;

            // Log timezone value for debugging
            Log::info('Updating timezone: ' . $timezone);

            // Get valid timezone offsets from helper
            $validTimezones = getTimezones();
            $validOffsets = array_column($validTimezones, 'timezone');

            // Check if timezone offset is valid
            if (!in_array($timezone, $validOffsets)) {
                Log::warning('Invalid timezone offset attempted: ' . $timezone);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid timezone. Please select a valid timezone.'
                ], 400);
            }

            // Update user timezone
            $user->update(['timezone' => $timezone]);

            Log::info('Timezone updated successfully for user ' . $user->id . ': ' . $timezone);

            // Find timezone label for response
            $timezoneLabel = '';
            foreach ($validTimezones as $tz) {
                if ($tz['timezone'] === $timezone) {
                    $timezoneLabel = $tz['label'];
                    break;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Timezone updated successfully',
                'timezone' => $timezone,
                'timezone_label' => $timezoneLabel
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating timezone: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'timezone' => $request->timezone ?? 'null'
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating timezone'
            ], 500);
        }
    }

    public function viewLoop(Request $request): JsonResponse
    {
        $request->validate(['id' => ['required', 'integer', 'min:1']]);

        $order = Order::query()
            ->where('user_id', Auth::id())
            ->where('dripfeed', true)
            ->whereNotNull('loop_quantity')
            ->whereNotNull('loop_spacing')
            ->with('service')
            ->findOrFail($request->integer('id'));

        $hasLoopParentColumn = Schema::hasColumn('orders', 'loop_parent_id');
        $hasLoopCurrentColumn = Schema::hasColumn('orders', 'loop_current');
        $children = $hasLoopParentColumn
            ? Order::query()
                ->where('user_id', Auth::id())
                ->where('loop_parent_id', $order->id)
                ->orderBy('id')
                ->get()
            : collect();

        $serviceName = $order->service?->name ?? 'N/A';
        if (is_array($serviceName)) {
            $lang = Auth::user()?->lang ?? 'en';
            $serviceName = $serviceName[$lang] ?? $serviceName['en'] ?? reset($serviceName) ?? 'N/A';
        }

        $done = $hasLoopCurrentColumn ? (int) ($order->loop_current ?? 0) : $children->count();
        $total = (int) $order->loop_quantity;
        $status = match (strtolower((string) $order->status)) {
            'in progress', 'in_progress', 'inprogress' => 'In progress',
            'awaiting' => 'Pending',
            default => ucfirst((string) $order->status),
        };

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $order->id,
                'link' => $order->link,
                'service' => (string) $serviceName,
                'order_quantity' => (int) $order->quantity,
                'charge' => (float) $order->charge,
                'loop_total' => $total,
                'loop_done' => min($done, $total),
                'loop_spacing' => (int) $order->loop_spacing,
                'order_start' => $order->created_at?->toDateTimeString(),
                'status' => $status,
                'display_status' => $status,
                'children' => $children->map(function (Order $child): array {
                    $status = match (strtolower((string) $child->status)) {
                        'in progress', 'in_progress', 'inprogress' => 'In progress',
                        'awaiting' => 'Awaiting',
                        default => ucfirst((string) $child->status),
                    };

                    return [
                        'id' => $child->id,
                        'orders_api' => $child->orders_api,
                        'order_start' => $child->created_at?->toDateTimeString(),
                        'order_remains' => (int) $child->remains,
                        'quantity' => (int) $child->quantity,
                        'charge' => (float) $child->charge,
                        'created_at' => $child->created_at?->toDateTimeString(),
                        'order_status' => $status,
                    ];
                })->values(),
            ],
        ]);
    }

    /**
     * Handle order actions (refill, cancel)
     */
    public function orderAction(Request $request, $id): JsonResponse
    {
        try {
            $order = Auth::user()->orders()->findOrFail($id);
            $action = $request->input('legacy_order_action');
            if (!$action) {
                $action = $request->route()->getName();
                $action = str_replace('clients.orders.', '', $action);
            }

            switch ($action) {
                case 'refill':
                    if ($order->refill != 1) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'This order cannot be refilled'
                        ], 400);
                    }

                    // Call provider API for refill
                    $apiResponse = $this->callProviderApi($order, 'refill');

                    // Check if API call failed
                    if (!$this->isApiActionSuccessful($apiResponse, $order->orders_api)) {
                        $errorMsg = $this->getApiErrorMessage($apiResponse, $order->orders_api);
                        Log::warning('Refill API error: ' . $errorMsg);
                        return response()->json([
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 400);
                    }

                    $order->update([
                        'refill' => 0,
                        'refill_status' => 'pending'
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'btn_text' => 'Refill requested',
                        'action' => 'refill'
                    ]);

                case 'cancel':
                    if ($order->cancel != 1) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'This order cannot be canceled'
                        ], 400);
                    }

                    if (blank($order->orders_api)) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'This order has no provider order ID',
                        ], 400);
                    }

                    // Call provider API for cancel
                    $apiResponse = $this->callProviderApi($order, 'cancel');

                    // Check if API call failed
                    if (!$this->isApiActionSuccessful($apiResponse, $order->orders_api)) {
                        $errorMsg = $this->getApiErrorMessage($apiResponse, $order->orders_api);
                        Log::warning('Cancel API error', [
                            'order_id' => $order->id,
                            'provider_order_id' => $order->orders_api,
                            'response' => $apiResponse,
                            'message' => $errorMsg,
                        ]);
                        return response()->json([
                            'status' => 'error',
                            'message' => $errorMsg
                        ], 400);
                    }

                    $user = $order->user;
                    $user->increment('balance', $order->charge);
                    $order->update([
                        'cancel' => 0,
                        'cancel_status' => 'pending'
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'btn_text' => 'Cancel requested',
                        'action' => 'cancel'
                    ]);

                default:
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid action'
                    ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error processing order action: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing your request'
            ], 500);
        }
    }

    /**
     * Handle order report (cancel/refill/speedup request)
     */
    public function orderReport(Request $request, $id): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:1,2,3',
        ]);

        try {
            $config = Config::where('domain', getDomain())->first();
            if (!serviceOn($config, 'service_allow_report')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order reports are currently disabled.',
                ], 403);
            }

            $order = Auth::user()->orders()->findOrFail($id);

            $ticketMap = [
                '1' => 'canceled',
                '2' => 'refill',
                '3' => 'speedup',
            ];

            $order->update(['ticket' => $ticketMap[$request->input('type')]]);

            $message = $request->input('lang') === 'vi'
                ? 'Báo cáo thành công'
                : 'Reported successfully';

            return response()->json(['success' => $message, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Create product order
     */
    public function createOrderProduct(Request $request, $id): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $user    = Auth::user();
            $product = Product::where('domain', getDomain())
                ->where('status', true)
                ->findOrFail($id);

            $quantity = (int) $request->input('quantity', 1);

            // Validate min/max
            if ($product->min && $quantity < $product->min) {
                return response()->json(['status' => 'error', 'message' => "Minimum quantity is {$product->min}"], 422);
            }
            if ($product->max && $quantity > $product->max) {
                return response()->json(['status' => 'error', 'message' => "Maximum quantity is {$product->max}"], 422);
            }

            $charge = (float) $product->price * $quantity;

            if ($user->balance < $charge) {
                return response()->json(['status' => 'error', 'message' => 'Insufficient balance'], 422);
            }

            $productOrder = null;
            DB::transaction(function () use ($user, $product, $quantity, $charge, &$productOrder) {
                $productOrder = ProductOrder::create([
                    'user_id'    => $user->id,
                    'domain'     => getDomain(),
                    'product_id' => $product->id,
                    'status'     => $product->type === 'manual' ? 'Manual' : 'Pending',
                    'amount'     => $charge,
                    'charge'     => $charge,
                    'quantity'   => $quantity,
                ]);

                $user->decrement('balance', $charge);

                // Record transaction
                $balanceAfter = number_format((float)$user->balance - $charge, 9, '.', '');
                Transaction::create([
                    'user_id'        => $user->id,
                    'order_id'       => null,
                    'amount'         => -$charge,
                    'type'           => 'order',
                    'status'         => 'completed',
                    'payment_method' => 'balance',
                    'transaction_id' => 'PRODUCT-' . $productOrder->id,
                    'description'    => 'Product order #' . $productOrder->id . ' - ' . $product->name,
                    'balance_after'  => $balanceAfter,
                    'domain'         => getDomain(),
                ]);
            });

            return response()->json([
                'status'   => 'success',
                'message'  => 'Order successfully',
                'order_id' => $productOrder->id ?? null,
                'charge'   => $charge,
                'redirect' => '/product_orders',
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Call provider API for order actions
     */
    private function callProviderApi(Order $order, string $action): array
    {
        // Check if order has provider info
        if (!$order->provider_id || !$order->orders_api) {
            return ['error' => 'Order does not have provider information'];
        }

        // Get provider
        $provider = ApiProvider::where('domain', getDomain())
            ->find($order->provider_id);
        if (!$provider || !$provider->status) {
            return ['error' => 'Provider is not available'];
        }

        // Initialize SMM API client
        $smm = new Smm();
        $smm->api_url = $provider->link;
        $smm->api_key = $provider->api_key;

        // Call appropriate API method
        try {
            if ($action === 'cancel') {
                // Always send the provider's order ID, never the local order
                // primary key. Smm::cancel() formats it as `orders=...`.
                $response = $smm->cancel($order->orders_api);
            } elseif ($action === 'refill') {
                $response = $smm->refill($order->orders_api);
            } else {
                return ['error' => 'Invalid action'];
            }

            // Convert object to array if needed
            if (is_object($response)) {
                $response = json_decode(json_encode($response), true);
            }

            // A provider may return null or a scalar when its endpoint fails;
            // normalize that response so the caller can return a useful error
            // instead of hiding it behind a generic exception.
            return is_array($response) ? $response : [
                'error' => 'Invalid response from provider',
                'provider_response' => is_scalar($response) ? (string) $response : null,
            ];
        } catch (\Exception $e) {
            Log::error("API {$action} error: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Check if API action was successful
     * API returns array with order data, check if action succeeded
     */
    private function isApiActionSuccessful(array $apiResponse, int|string $orderId): bool
    {
        // If error key exists at top level, it's a general error
        if (isset($apiResponse['error'])) {
            return false;
        }

        // API returns array of results, find the order result
        if (is_array($apiResponse) && !empty($apiResponse)) {
            foreach ($apiResponse as $result) {
                // Some providers return {"cancel": 1} instead of an array
                // containing an explicit order field.
                if (is_array($result) && isset($result['cancel']) &&
                    ($result['cancel'] === true || is_numeric($result['cancel']) && (int) $result['cancel'] > 0)) {
                    return true;
                }
                if (isset($result['order']) && $result['order'] == $orderId) {
                    // Check if action succeeded (value should be 1 or true, not an error array)
                    $actionKey = array_key_first(array_diff_key($result, ['order' => null]));
                    if ($actionKey) {
                        $actionValue = $result[$actionKey];
                        // If it's an array with 'error' key, action failed
                        if (is_array($actionValue) && isset($actionValue['error'])) {
                            return false;
                        }
                        // If value is 1 or true, action succeeded
                        return $actionValue === true ||
                            is_numeric($actionValue) && (int) $actionValue > 0;
                    }
                }
            }

            // Also support responses keyed by the provider order id:
            // {"360": 1} or {"360": {"cancel": 1}}.
            if (array_key_exists((string) $orderId, $apiResponse)) {
                $result = $apiResponse[(string) $orderId];
                return $result === true || is_numeric($result) && (int) $result > 0 ||
                    (is_array($result) && (($result['cancel'] ?? null) === true ||
                        is_numeric($result['cancel'] ?? null) && (int) $result['cancel'] > 0));
            }
        }

        return false;
    }

    /**
     * Get error message from API response
     */
    private function getApiErrorMessage(array $apiResponse, int|string $orderId): string
    {
        // Check for top-level error
        if (isset($apiResponse['error'])) {
            return is_scalar($apiResponse['error'])
                ? (string) $apiResponse['error']
                : 'Provider returned an invalid error response';
        }

        // Find error in order-specific response
        if (is_array($apiResponse) && !empty($apiResponse)) {
            foreach ($apiResponse as $result) {
                if (isset($result['order']) && $result['order'] == $orderId) {
                    $actionKey = array_key_first(array_diff_key($result, ['order' => null]));
                    if ($actionKey) {
                        $actionValue = $result[$actionKey];
                        if (is_array($actionValue) && isset($actionValue['error'])) {
                            return (string) $actionValue['error'];
                        }
                        if (is_string($actionValue) && $actionValue !== '') {
                            return $actionValue;
                        }
                    }
                }
            }
        }

        if (isset($apiResponse['provider_response'])) {
            return (string) $apiResponse['provider_response'];
        }

        // Providers do not all use the same response shape. Surface the first
        // nested error message instead of replacing it with a generic one.
        $findError = static function (mixed $value) use (&$findError): ?string {
            if (!is_array($value)) {
                return null;
            }
            if (isset($value['error']) && is_scalar($value['error']) && (string) $value['error'] !== '') {
                return (string) $value['error'];
            }
            foreach ($value as $child) {
                $error = $findError($child);
                if ($error !== null) {
                    return $error;
                }
            }
            return null;
        };

        $nestedError = $findError($apiResponse);
        if ($nestedError !== null) {
            return $nestedError;
        }

        return 'An error occurred while processing your request';
    }

    /**
     * Generate TOTP secret + QR code URL for enabling 2FA
     */
    public function twoFaSetup(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $google2fa = new \PragmaRX\Google2FA\Google2FA();

            // Reuse existing pending secret or generate new one
            $secret = $user->two_factor_secret;
            if (!$secret || $user->two_factor_enabled) {
                $secret = $google2fa->generateSecretKey(16);
                $user->update(['two_factor_secret' => $secret]);
            }

            $issuer   = config('app.name', 'App');
            $otpauth  = $google2fa->getQRCodeUrl($issuer, $user->email, $secret);
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200, 2),
                new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
            );
            $svg = (new \BaconQrCode\Writer($renderer))->writeString($otpauth);

            return response()->json([
                'success' => true,
                'secret'  => $secret,
                'qr_url'  => 'data:image/svg+xml;base64,' . base64_encode($svg),
            ]);
        } catch (\Exception $e) {
            Log::error('Error setting up 2FA: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate 2FA setup.'], 500);
        }
    }

    /**
     * Generate 2FA code and send to user email (used for disable flow)
     */
    public function twoFaGenerate(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            // Generate a random 6-digit code
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store the code in session with expiry (10 minutes)
            session(['2fa_code' => $code, '2fa_code_expires' => now()->addMinutes(10)]);

            // Send code to user email
            Mail::raw("Your two-factor authentication code is: {$code}\n\nThis code will expire in 10 minutes.", function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Two-Factor Authentication Code');
            });

            return response()->json([
                'success' => true,
                'message' => 'A verification code has been sent to your email address'
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating 2FA code: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending the verification code'
            ], 500);
        }
    }

    /**
     * Approve TOTP code and enable 2FA
     */
    public function twoFaApprove(Request $request): JsonResponse
    {
        try {
            $request->validate(['code' => 'required|string']);

            $user   = Auth::user();
            $secret = $user->two_factor_secret;

            if (!$secret) {
                return response()->json(['success' => false, 'message' => 'No 2FA setup found. Please start setup again.'], 400);
            }

            $google2fa = new \PragmaRX\Google2FA\Google2FA();
            $valid     = $google2fa->verifyKey($secret, $request->code);

            if (!$valid) {
                return response()->json(['success' => false, 'message' => 'Invalid authentication code. Please try again.'], 400);
            }

            $user->update(['two_factor_enabled' => true]);

            return response()->json(['success' => true, 'message' => 'Two-factor authentication has been enabled successfully.']);
        } catch (\Exception $e) {
            Log::error('Error approving 2FA code: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while verifying the code.'], 500);
        }
    }

    /**
     * Disable 2FA for user (verify TOTP code first)
     */
    public function twoFaDisable(Request $request): JsonResponse
    {
        try {
            $request->validate(['code' => 'required|string']);

            $user = Auth::user();

            if (!$user->two_factor_enabled) {
                return response()->json(['success' => false, 'message' => 'Two-factor authentication is not enabled.'], 400);
            }

            $google2fa = new \PragmaRX\Google2FA\Google2FA();
            $valid     = $google2fa->verifyKey($user->two_factor_secret, $request->code);

            if (!$valid) {
                return response()->json(['success' => false, 'message' => 'Invalid authentication code. Please try again.'], 400);
            }

            $user->update(['two_factor_enabled' => false, 'two_factor_secret' => null]);

            return response()->json(['success' => true, 'message' => 'Two-factor authentication has been disabled successfully.']);
        } catch (\Exception $e) {
            Log::error('Error disabling 2FA: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while disabling 2FA.'], 500);
        }
    }

    /**
     * Generate new API key for user
     */
    public function generateApiKey(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();

            // Generate new unique API key
            do {
                $apiKey = Str::random(32);
            } while (User::where('api_key', $apiKey)->exists());

            // Update user's API key
            $user->update(['api_key' => $apiKey]);

            return response()->json([
                'success' => true,
                'message' => 'API key generated successfully',
                'api_key' => $apiKey
            ]);
        } catch (\Exception $e) {
            Log::error('Error generating API key: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while generating API key'
            ], 500);
        }
    }

    /**
     * Create child panel
     */
    public function createChildPanel(Request $request): JsonResponse
    {
        try {
            // Legacy child-panel forms may omit currency. Use the current
            // user's currency (or the domain default) instead of returning a
            // validation 422 for an optional UI field.
            if (!$request->filled('currency')) {
                $request->merge([
                    'currency' => Auth::user()?->currency
                        ?: Config::where('domain', getDomain())->value('default_currency')
                        ?: 'USD',
                ]);
            }
            if (!$request->filled('username')) {
                $request->merge(['username' => Auth::user()?->username ?: 'admin']);
            }
            if (!$request->filled('password')) {
                $generatedPassword = bin2hex(random_bytes(16));
                $request->merge([
                    'password' => $generatedPassword,
                    'password_confirmation' => $generatedPassword,
                ]);
            }
            Log::info('Child panel request received', [
                'user_id' => Auth::id(),
                'domain' => $request->input('domain'),
                'currency' => $request->input('currency'),
            ]);
            // Validation rules
            $validator = Validator::make($request->all(), [
                'domain' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:child_panels,domain_panel',
                    'regex:/^(?!:\/\/)([a-zA-Z0-9-_]+\.)*[a-zA-Z0-9][a-zA-Z0-9-_]+\.[a-zA-Z]{2,11}?$/i'
                ],
                'currency' => 'required|string',
                'username' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'domain.required' => 'Domain is required',
                'domain.regex' => 'Invalid domain name',
                'domain.unique' => 'This domain is already registered',
                'username.required' => 'Admin username is required',
                'password.required' => 'Admin password is required',
                'password.confirmed' => 'Password confirmation does not match',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => $validator->errors()->first()
                ], 422);
            }

            // Get config for child panel cost
            $config = Config::where('domain', getDomain())->first();
            $cost = $config->child_panel_cost ?? 0;

            // Check user balance
            $user = Auth::user();
            if ($user->balance < $cost) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient balance. Required: $' . number_format($cost, 2)
                ], 422);
            }

            // Initialize Cloudflare
            $cloudflare = new \App\Library\CloudflareCustom();

            // Check if Cloudflare is configured
            if (!$cloudflare->isConfigured()) {
                $configStatus = $cloudflare->getConfigStatus();

                Log::error('Cloudflare not properly configured', [
                    'domain' => $request->domain,
                    'user_id' => $user->id,
                    'config_status' => $configStatus
                ]);

                $missingFields = implode(', ', $configStatus['missing_fields']);

                return response()->json([
                    'success' => false,
                    'message' => "Cloudflare is not properly configured. Missing fields: $missingFields. Please contact administrator.",
                    'code' => 'CLOUDFLARE_NOT_CONFIGURED',
                    'missing_fields' => $configStatus['missing_fields']
                ], 422);
            }

            try {
                // Create domain with automatic DNS and IP configuration
                $cloudflareResult = $cloudflare->createDomainWithAutoConfig($request->domain);

                if ($cloudflareResult['status'] !== 'success') {
                    Log::error('Cloudflare domain creation failed', [
                        'domain' => $request->domain,
                        'error' => $cloudflareResult['message'],
                        'code' => $cloudflareResult['code'] ?? null
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to configure domain on Cloudflare: ' . $cloudflareResult['message'],
                        'cloudflare_error' => $cloudflareResult['message'],
                        'code' => $cloudflareResult['code'] ?? null
                    ], 422);
                }

                $cloudflareData = $cloudflareResult['data'];
                Log::info('Cloudflare domain created', [
                    'domain' => $request->domain,
                    'zone_id' => $cloudflareData['zone_id']
                ]);
            } catch (\Exception $cfException) {
                Log::error('Cloudflare exception', [
                    'domain' => $request->domain,
                    'error' => $cfException->getMessage()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Cloudflare error: ' . $cfException->getMessage()
                ], 422);
            }

            // Create child panel in transaction
            $childPanel = DB::transaction(function () use ($user, $cost, $request, $cloudflareData) {
                $childPanel = ChildPanel::create([
                    'user_id' => $user->id,
                    'domain' => getDomain(),
                    'domain_panel' => strtolower($request->domain),
                    'price' => $cost,
                    'status' => 'pending',
                ]);

                // Store admin credentials and settings
                $childPanel->setSetting('admin_username', $request->username);
                $childPanel->setSetting('admin_password', Hash::make($request->password));
                $childPanel->setSetting('currency', $request->currency);

                // Store Cloudflare data
                $childPanel->setSetting('cloudflare_zone_id', $cloudflareData['zone_id']);
                $childPanel->setSetting('cloudflare_dns_id', $cloudflareData['dns_id']);
                $childPanel->setSetting('cloudflare_nameserver1', $cloudflareData['nameserver1']);
                $childPanel->setSetting('cloudflare_nameserver2', $cloudflareData['nameserver2']);
                $childPanel->setSetting('cloudflare_status', $cloudflareData['zone_status']);
                $childPanel->setSetting('cloudflare_configured_at', $cloudflareData['created_at']);

                // Deduct cost from user balance
                if ($cost > 0) {
                    $user->decrement('balance', $cost);
                }

                return $childPanel;
            });

            return response()->json([
                'success' => true,
                'message' => 'Child panel created successfully. Domain configured on Cloudflare.',
                'data' => [
                    'id' => $childPanel->id,
                    'domain' => $childPanel->domain_panel,
                    'cloudflare' => [
                        'zone_id' => $cloudflareData['zone_id'],
                        'nameserver1' => $cloudflareData['nameserver1'],
                        'nameserver2' => $cloudflareData['nameserver2'],
                        'status' => $cloudflareData['zone_status'],
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating child panel', [
                'domain' => $request->domain ?? null,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
