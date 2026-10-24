<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Client\DataController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Service;
use App\Models\User; 
use App\Smm\Smm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class ApiV2Controller extends Controller
{
    public function balance(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            return response()->json([
                'balance' => (float) $user->balance,
                'currency' => 'USD'
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Incorrect request'], 200);
        }
    }

    public function services(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $services = Service::with('category')
                ->where('status', true)
                ->where(function ($query) {
                    $query->where('hidden_api', false)->orWhereNull('hidden_api');
                })
                ->ordered()
                ->get()
                ->map(fn(Service $service) => [
                    'service' => (int) $service->id,
                    'name' => $service->getName('en'),
                    'type' => $service->type_service ?: 'Default',
                    'category' => $service->category?->getName('en') ?: 'General',
                    'rate' => number_format(getUserServiceRate($user, $service), 4, '.', ''),
                    'min' => (int) $service->min,
                    'max' => (int) $service->max,
                    'refill' => (bool) $service->refill,
                    'cancel' => (bool) $service->cancel,
                ])
                ->values();

            return response()->json($services, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Incorrect request'], 200);
        }
    }

    /**
     * Create order
     */
    public function create(Request $request): JsonResponse
    {
        try {
            if (!$request->filled('service')) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            $user = $request->user();

            $orderRequest = new Request($request->all());
            $orderRequest->merge(['comments' => $request->input('comments', $request->input('comment'))]);
            $orderRequest->setUserResolver(fn () => $user);

            // DataController reads Auth::user(), while API authentication is
            // resolved from the request. Temporarily bind the API user only
            // for this operation and restore the previous guard user after it.
            $guard = Auth::guard();
            $previousUser = $guard->user();
            $guard->setUser($user);

            try {
                $result = app(DataController::class)
                    ->createOrder($orderRequest)
                    ->getData(true);
            } finally {
                $guard->setUser($previousUser);
            }
            return ($result['success'] ?? false) && isset($result['order_id'])
                ? response()->json(['order' => (int) $result['order_id']], 200)
                : response()->json(['error' => $result['message'] ?? 'Incorrect request'], 200);
        } catch (Exception $e) {
            Log::error('API create order error: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage() ?: 'An error occurred while creating the order. Please try again.'
            ], 200);
        }
    }

    /**
     * Get order status
     */
    public function status(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Support both 'order' and 'order_id' parameter names
            $orderId = $request->input('order') ?? $request->input('order_id');

            if (!$orderId) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }


            // Check if this is a provider request (has api_url)
            if ($request->has('api_url')) {
                $smm = new Smm();
                $smm->api_key = $request->api_key;
                $smm->api_url = $request->api_url;

                return response()->json([
                    'status' => 'success',
                    'data' => $smm->status($orderId)
                ], 200);
            }

            // Local database request - get order from database
            $order = Order::where('id', $orderId)
                ->where('user_id', $user->id)
                ->first();

            if (!$order) {
                return response()->json(['error' => 'Order not found'], 200);
            }

            // If order doesn't have provider info, return local status
            if (!$order->orders_api || !$order->apiProvider) {
                return response()->json([
                    'charge' => number_format($order->charge, 5, '.', ''),
                    'start_count' => (string) $order->start_count,
                    'status' => ucfirst($order->status),
                    'remains' => (string) $order->remains,
                    'currency' => $order->currency ?? 'USD'
                ], 200);
            }

            // Get status from provider
            try {
                $smm = new Smm();
                $smm->api_key = $order->apiProvider->api_key;
                $smm->api_url = $order->apiProvider->api_url;

                $providerStatus = $smm->status($order->orders_api);

                return response()->json([
                    'charge' => number_format($order->charge, 5, '.', ''),
                    'start_count' => (string) ($providerStatus->start_count ?? $order->start_count),
                    'status' => $providerStatus->status ?? ucfirst($order->status),
                    'remains' => (string) ($providerStatus->remains ?? $order->remains),
                    'currency' => $order->currency ?? 'USD'
                ], 200);
            } catch (Exception $e) {
                // If provider request fails, return local status
                return response()->json([
                    'charge' => number_format($order->charge, 5, '.', ''),
                    'start_count' => (string) $order->start_count,
                    'status' => ucfirst($order->status),
                    'remains' => (string) $order->remains,
                    'currency' => $order->currency ?? 'USD'
                ], 200);
            }
        } catch (Exception $e) {
            Log::error('API status error: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request'], 200);
        }
    }

    /**
     * Get multiple orders status
     */
    public function multiStatus(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Support both 'orders' (comma-separated string) and 'order_ids' (array)
            $orderIds = [];
            if ($request->has('orders')) {
                // Parse comma-separated string
                $orderIds = array_map('trim', explode(',', $request->orders));
                $orderIds = array_filter($orderIds);  // Remove empty values
            } elseif ($request->has('order_ids')) {
                $orderIds = is_array($request->order_ids) ? $request->order_ids : [$request->order_ids];
            } else {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Limit to 100 IDs
            $orderIds = array_slice($orderIds, 0, 100);

            if (empty($orderIds)) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Check if this is a provider request (has api_url)
            if ($request->has('api_url')) {
                $smm = new Smm();
                $smm->api_key = $request->api_key;
                $smm->api_url = $request->api_url;
                return response()->json($smm->multiStatus($orderIds), 200);
            }

            // Local database request - get orders and group by provider
            $orders = Order::whereIn('id', $orderIds)
                ->where('user_id', $user->id)
                ->with('apiProvider')
                ->get()
                ->keyBy('id');

            $results = [];

            foreach ($orderIds as $orderId) {
                $order = $orders->get($orderId);

                // Order not found or doesn't belong to user
                if (!$order) {
                    $results[(string) $orderId] = ['error' => 'Incorrect order ID'];
                    continue;
                }

                // If order doesn't have provider info, return local status
                if (!$order->orders_api || !$order->apiProvider) {
                    $results[(string) $orderId] = [
                        'charge' => number_format($order->charge, 5, '.', ''),
                        'start_count' => (string) $order->start_count,
                        'status' => ucfirst($order->status),
                        'remains' => (string) $order->remains,
                        'currency' => $order->currency ?? 'USD'
                    ];
                    continue;
                }

                // Get status from provider
                try {
                    $smm = new Smm();
                    $smm->api_key = $order->apiProvider->api_key;
                    $smm->api_url = $order->apiProvider->api_url;

                    $providerStatus = $smm->status($order->orders_api);

                    $results[(string) $orderId] = [
                        'charge' => number_format($order->charge, 5, '.', ''),
                        'start_count' => (string) ($providerStatus->start_count ?? $order->start_count),
                        'status' => $providerStatus->status ?? ucfirst($order->status),
                        'remains' => (string) ($providerStatus->remains ?? $order->remains),
                        'currency' => $order->currency ?? 'USD'
                    ];
                } catch (Exception $e) {
                    // If provider request fails, return local status
                    $results[(string) $orderId] = [
                        'charge' => number_format($order->charge, 5, '.', ''),
                        'start_count' => (string) $order->start_count,
                        'status' => ucfirst($order->status),
                        'remains' => (string) $order->remains,
                        'currency' => $order->currency ?? 'USD'
                    ];
                }
            }

            return response()->json($results, 200);
        } catch (Exception $e) {
            Log::error('API multi-status error: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request'], 200);
        }
    }

    /**
     * Create refill request
     */
    public function refill(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Support both 'order' and 'order_id' parameter names
            $orderId = $request->input('order') ?? $request->input('order_id');

            if (!$orderId) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }


            // Check if this is a provider request (has api_url)
            if ($request->has('api_url')) {
                $smm = new Smm();
                $smm->api_key = $request->api_key;
                $smm->api_url = $request->api_url;

                return response()->json($smm->refill($orderId), 200);
            }

            // Local database request - get order from database
            $order = Order::where('id', $orderId)
                ->where('user_id', $user->id)
                ->first();

            if (!$order) {
                return response()->json(['error' => 'Order not found'], 200);
            }

            // Check if order can be refilled
            if (!$order->refill) {
                return response()->json(['error' => 'This order cannot be refilled'], 200);
            }

            // If order doesn't have provider info, return error
            if (!$order->orders_api || !$order->apiProvider) {
                return response()->json(['error' => 'Order does not have provider information'], 200);
            }

            // Call provider API for refill
            try {
                $smm = new Smm();
                $smm->api_key = $order->apiProvider->api_key;
                $smm->api_url = $order->apiProvider->api_url;

                $providerResponse = $smm->refill($order->orders_api);

                // Check if refill was successful
                $refillSuccess = false;
                if (is_object($providerResponse)) {
                    $refillSuccess = isset($providerResponse->refill) && $providerResponse->refill == 1;
                } elseif (is_array($providerResponse)) {
                    $refillSuccess = isset($providerResponse['refill']) && $providerResponse['refill'] == 1;
                }

                if ($refillSuccess) {
                    $order->update([
                        'refill' => 0,
                        'refill_status' => 'pending'
                    ]);

                    return response()->json(['refill' => 1], 200);
                } else {
                    // Provider returned error
                    $errorMsg = 'Refill failed';
                    if (is_object($providerResponse) && isset($providerResponse->error)) {
                        $errorMsg = $providerResponse->error;
                    } elseif (is_array($providerResponse) && isset($providerResponse['error'])) {
                        $errorMsg = $providerResponse['error'];
                    }

                    return response()->json(['error' => $errorMsg], 200);
                }
            } catch (Exception $e) {
                Log::error("API refill error for order {$orderId}: " . $e->getMessage());
                return response()->json(['error' => 'An error occurred while refilling the order'], 200);
            }
        } catch (Exception $e) {
            Log::error('API refill error: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request'], 200);
        }
    }

    /**
     * Create multiple refill requests
     */
    public function multiRefill(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Support both 'orders' (comma-separated string) and 'order_ids' (array)
            $orderIds = [];
            if ($request->has('orders')) {
                // Parse comma-separated string
                $orderIds = array_map('trim', explode(',', $request->orders));
                $orderIds = array_filter($orderIds);  // Remove empty values
            } elseif ($request->has('order_ids')) {
                $orderIds = is_array($request->order_ids) ? $request->order_ids : [$request->order_ids];
            } else {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Limit to 100 IDs
            $orderIds = array_slice($orderIds, 0, 100);

            if (empty($orderIds)) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Check if this is a provider request (has api_url)
            if ($request->has('api_url')) {
                $smm = new Smm();
                $smm->api_key = $request->api_key;
                $smm->api_url = $request->api_url;
                return response()->json($smm->multiRefill($orderIds), 200);
            }

            // Local database request - process each order
            $results = [];

            foreach ($orderIds as $orderId) {
                $order = Order::where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->first();

                // Order not found or doesn't belong to user
                if (!$order) {
                    $results[] = [
                        'order' => (int) $orderId,
                        'refill' => ['error' => 'Incorrect order ID']
                    ];
                    continue;
                }

                // Check if order can be refilled
                if (!$order->refill) {
                    $results[] = [
                        'order' => (int) $orderId,
                        'refill' => ['error' => 'This order cannot be refilled']
                    ];
                    continue;
                }

                // If order doesn't have provider info, return error
                if (!$order->orders_api || !$order->apiProvider) {
                    $results[] = [
                        'order' => (int) $orderId,
                        'refill' => ['error' => 'Order does not have provider information']
                    ];
                    continue;
                }

                // Call provider API for refill
                try {
                    $smm = new Smm();
                    $smm->api_key = $order->apiProvider->api_key;
                    $smm->api_url = $order->apiProvider->api_url;

                    $providerResponse = $smm->refill($order->orders_api);

                    // Check if refill was successful
                    $refillSuccess = false;
                    if (is_object($providerResponse)) {
                        $refillSuccess = isset($providerResponse->refill) && $providerResponse->refill == 1;
                    } elseif (is_array($providerResponse)) {
                        $refillSuccess = isset($providerResponse['refill']) && $providerResponse['refill'] == 1;
                    }

                    if ($refillSuccess) {
                        $order->update([
                            'refill' => 0,
                            'refill_status' => 'pending'
                        ]);

                        $results[] = [
                            'order' => (int) $orderId,
                            'refill' => 1
                        ];
                    } else {
                        // Provider returned error
                        $errorMsg = 'Refill failed';
                        if (is_object($providerResponse) && isset($providerResponse->error)) {
                            $errorMsg = $providerResponse->error;
                        } elseif (is_array($providerResponse) && isset($providerResponse['error'])) {
                            $errorMsg = $providerResponse['error'];
                        }

                        $results[] = [
                            'order' => (int) $orderId,
                            'refill' => ['error' => $errorMsg]
                        ];
                    }
                } catch (Exception $e) {
                    Log::error("API refill error for order {$orderId}: " . $e->getMessage());
                    $results[] = [
                        'order' => (int) $orderId,
                        'refill' => ['error' => 'An error occurred while refilling the order']
                    ];
                }
            }

            return response()->json($results, 200);
        } catch (Exception $e) {
            Log::error('API multi-refill error: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request'], 200);
        }
    }

    /**
     * Cancel order(s)
     * Supports both single order and multiple orders (comma-separated)
     */
    public function cancel(Request $request): JsonResponse
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Parse order IDs - support both 'order' (single) and 'orders' (multiple)
            $orderIds = [];
            if ($request->has('orders')) {
                // Parse comma-separated string
                $orderIds = array_map('trim', explode(',', $request->orders));
                $orderIds = array_filter($orderIds);  // Remove empty values
            } elseif ($request->has('order')) {
                $orderIds = [$request->order];
            } else {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Limit to 100 IDs
            $orderIds = array_slice($orderIds, 0, 100);

            if (empty($orderIds)) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Check if this is a provider request (has api_url)
            if ($request->has('api_url')) {
                $smm = new Smm();
                $smm->api_key = $request->api_key;
                $smm->api_url = $request->api_url;

                return response()->json($smm->cancel($orderIds), 200);
            }

            // Local database request - process each order
            $results = [];

            foreach ($orderIds as $orderId) {
                $order = Order::where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->first();

                // Order not found or doesn't belong to user
                if (!$order) {
                    $results[] = [
                        'order' => (int) $orderId,
                        'cancel' => ['error' => 'Incorrect order ID']
                    ];
                    continue;
                }

                // Check if order can be canceled
                if (!$order->cancel) {
                    $results[] = [
                        'order' => (int) $orderId,
                        'cancel' => ['error' => 'This order cannot be canceled']
                    ];
                    continue;
                }

                // If order doesn't have provider info, handle local cancel
                if (!$order->orders_api || !$order->apiProvider) {
                    // Local cancel - refund the charge
                    $user->increment('balance', $order->charge);
                    $order->update([
                        'cancel' => 0,
                        'cancel_status' => 'completed',
                        'status' => 'canceled'
                    ]);

                    $results[] = [
                        'order' => (int) $orderId,
                        'cancel' => 1
                    ];
                    continue;
                }

                // Call provider API for cancel
                try {
                    $smm = new Smm();
                    $smm->api_key = $order->apiProvider->api_key;
                    $smm->api_url = $order->apiProvider->api_url;

                    $providerResponse = $smm->cancel($order->orders_api);

                    // Check if cancel was successful
                    $cancelSuccess = false;
                    if (is_object($providerResponse)) {
                        $cancelSuccess = isset($providerResponse->cancel) && $providerResponse->cancel == 1;
                    } elseif (is_array($providerResponse)) {
                        $cancelSuccess = isset($providerResponse['cancel']) && $providerResponse['cancel'] == 1;
                    }

                    if ($cancelSuccess) {
                        // Refund the charge
                        $user->increment('balance', $order->charge);
                        $order->update([
                            'cancel' => 0,
                            'cancel_status' => 'completed',
                            'status' => 'canceled'
                        ]);

                        $results[] = [
                            'order' => (int) $orderId,
                            'cancel' => 1
                        ];
                    } else {
                        // Provider returned error
                        $errorMsg = 'Cancel failed';
                        if (is_object($providerResponse) && isset($providerResponse->error)) {
                            $errorMsg = $providerResponse->error;
                        } elseif (is_array($providerResponse) && isset($providerResponse['error'])) {
                            $errorMsg = $providerResponse['error'];
                        }

                        $results[] = [
                            'order' => (int) $orderId,
                            'cancel' => ['error' => $errorMsg]
                        ];
                    }
                } catch (Exception $e) {
                    Log::error("API cancel error for order {$orderId}: " . $e->getMessage());
                    $results[] = [
                        'order' => (int) $orderId,
                        'cancel' => ['error' => 'An error occurred while canceling the order']
                    ];
                }
            }

            // Return array format for multiple orders, single object for single order
            if (count($orderIds) === 1) {
                return response()->json($results[0], 200);
            }

            return response()->json($results, 200);
        } catch (Exception $e) {
            Log::error('API cancel error: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request'], 200);
        }
    }

    /** List products available on this domain. */
    public function products(Request $request): JsonResponse
    {
        $user = $request->user();

        $products = Product::where('domain', getDomain())
            ->where('status', '!=', 'Inactive')
            ->with('category')
            ->orderBy('position')
            ->get()
            ->map(fn (Product $product) => [
                'product' => $product->id,
                'name' => $product->name,
                'require' => $product->process_type ?: '',
                'rate' => getUserProductRate($user, $product),
                'min' => (int) $product->min,
                'max' => (int) $product->max,
                'category' => $product->category?->name ?? '',
                'status' => $product->status,
                'type' => $product->type === 'Api' ? 'Auto' : 'Service',
            ]);

        return response()->json($products, 200);
    }

    /** Create a product order using the same flow as the client order form. */
    public function addProductOrder(Request $request): JsonResponse
    {
        if (!$request->filled('product') ||
            !filter_var($request->product, FILTER_VALIDATE_INT) ||
            ($request->has('quantity') &&
                (!filter_var($request->quantity, FILTER_VALIDATE_INT) || (int) $request->quantity < 1))) {
            return response()->json(['error' => 'Incorrect request'], 200);
        }

        $user = $request->user();

        $product = Product::where('domain', getDomain())->where('status', 'In stock')->find($request->product);
        if (!$product) {
            return response()->json(['error' => 'Product not available'], 200);
        }

        // The client order flow handles balance deduction and transaction creation.
        $orderRequest = new Request([
            'quantity' => (int) ($request->input('quantity') ?: 1),
            'require' => $request->input('require'),
        ]);
        $orderRequest->setUserResolver(fn () => $user);

        $guard = Auth::guard();
        $previousUser = $guard->user();
        $guard->setUser($user);

        try {
            $response = app(DataController::class)
                ->createOrderProduct($orderRequest, $product->id);
            $data = $response->getData(true);

            if (($data['status'] ?? null) === 'success' && !blank($request->input('require'))) {
                ProductOrder::where('id', $data['order_id'])
                    ->where('user_id', $user->id)
                    ->update(['note' => (string) $request->input('require')]);
            }

            return ($data['status'] ?? null) === 'success' && isset($data['order_id'])
                ? response()->json(['order' => (int) $data['order_id']], 200)
                : response()->json(['error' => $data['message'] ?? 'Unable to create product order'], 200);
        } catch (\Throwable $e) {
            Log::error('API product order error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to create product order'], 200);
        } finally {
            $guard->setUser($previousUser);
        }
    }

    /** Get one or multiple product orders belonging to the API user. */
    public function productOrderStatus(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($request->has('orders')) {
            $ids = is_array($request->orders)
                ? $request->orders
                : explode(',', (string) $request->orders);
            $ids = array_slice(array_filter(array_map('trim', $ids)), 0, 100);
            if (!$ids || count(array_filter($ids, fn ($id) => !ctype_digit((string) $id))) > 0) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            $orders = ProductOrder::where('user_id', $user->id)->where('domain', getDomain())
                ->whereIn('id', $ids)->get()->keyBy('id');
            $results = [];
            foreach ($ids as $id) {
                $order = $orders->get($id);
                $results[(string) $id] = $order
                    ? ['charge' => (float) $order->charge, 'status' => $order->status,
                        'result' => $order->note ?? '']
                    : ['error' => 'Incorrect order ID'];
            }

            return response()->json($results, 200);
        }

        if (!$request->filled('order') || !ctype_digit((string) $request->order)) {
            return response()->json(['error' => 'Incorrect request'], 200);
        }

        $order = ProductOrder::where('user_id', $user->id)->where('domain', getDomain())
            ->find($request->order);
        return $order
            ? response()->json(['charge' => (float) $order->charge, 'status' => $order->status,
                'result' => $order->note ?? ''], 200)
            : response()->json(['error' => 'Incorrect order ID'], 200);
    }

    /** Retrieve the delivered result of a product order. */
    public function resultProduct(Request $request): JsonResponse
    {
        if (!ctype_digit((string) $request->order)) {
            return response()->json(['error' => 'Incorrect request'], 200);
        }

        $user = $request->user();

        $order = ProductOrder::where('user_id', $user->id)->where('domain', getDomain())
            ->find($request->order);
        if (!$order) {
            return response()->json(['error' => 'Incorrect order ID'], 200);
        }

        $result = json_decode((string) $order->note, true);
        return response()->json(['result' => is_array($result) ? $result :
            ($order->note ? [(string) $order->note] : [])], 200);
    }

    /**
     * Handle old API format (action-based)
     */
    public function handleAction(Request $request): JsonResponse
    {
        try {
            if (!$request->filled(['action', 'key']) && !$request->filled(['action', 'api_key'])) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            // Authenticate once for every action dispatched through this
            // endpoint, then forward the authenticated user to the action.
            $key = $request->input('key', $request->input('api_key'));
            $user = User::where('api_key', $key)
                ->where('is_active', true)
                ->first();

            if (!$user) {
                return response()->json(['error' => 'Incorrect request'], 200);
            }

            $request->merge(['api_key' => $key]);
            $request->attributes->set('api_user', $user);
            $request->setUserResolver(fn () => $user);

            return match ($request->action) {
                'balance' => response()->json([
                    'balance' => (float) $user->balance,
                    'currency' => 'USD',
                ], 200),
                'services' => $this->services($request),
                'products' => $this->products($request),
                'add_product_order' => $this->addProductOrder($request),
                'product_order_status' => $this->productOrderStatus($request),
                'result_product' => $this->resultProduct($request),
                'add' => $this->create($request),
                'status' => $request->has('orders') || $request->has('order_ids')
                    ? $this->multiStatus($request)
                    : ($request->has('order')
                        ? $this->status($request)
                        : response()->json(['error' => 'Incorrect request'], 200)),
                'cancel', 'multi_cancel' => $this->cancel($request),
                'refill', 'multi_refill' => $request->has('orders')
                    ? $this->multiRefill($request)
                    : ($request->has('order')
                        ? $this->refill($request)
                        : response()->json(['error' => 'Incorrect request'], 200)),
                default => response()->json(['error' => 'Incorrect request'], 200),
            };
        } catch (Exception $e) {
            return response()->json(['error' => 'Incorrect request'], 200);
        }
    }

}
