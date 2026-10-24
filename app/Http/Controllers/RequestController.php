<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RequestController extends Controller
{
    private const CLIENT_ACTIONS = [
        'Order-newOrder', 'Service-confirmService', 'Coupon-checkExistCoupon',
        'Order-getFbIdFromLink', 'Account-changeEmailPhone', 'Account-changePassword',
        'Account-changeApiKey', 'Account-enableGGAuth', 'Account-disableGGAuth',
        'Account-changeLanguage', 'Account-changeCurrency', 'Account-loadNote',
        'Account-saveNote', 'Payment-history', 'Payment-getInvoice',
        'Order-viewLoop',
        'Panel-createChildPanel', 'Product-buyProduct',
        'Ticket-reportOrder', 'Cancel-request',
    ];

    private const ACCOUNT_TRANSACTION_ACTIONS = [
        'transactions', 'transactionsOld', 'getTransactions', 'listTransaction',
    ];

    private const ADMIN_TRANSACTION_ACTIONS = [
        'listTransaction', 'listTransactionOld',
    ];

    public function handleClient(Request $request)
    {
        [$entity, $method, $action] = $this->parseAction((string) $request->input('action'));
        if (!$entity || !$method) {
            return response()->json(['error' => "Invalid action: {$action}"], 400);
        }

        if ($request->has('data') && is_array($request->input('data'))) {
            $request->merge($request->input('data'));
        }

        // Older client dashboard.js sends cancellation requests as
        // `Cancel-request` through /request instead of using the orders route.
        if ($action === 'Cancel-request') {
            // /orders is also available to authenticated administrator
            // sessions in the client preview, so only reject guests here.
            if (!Auth::check()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $request->merge(['legacy_order_action' => 'cancel']);

            return app('App\\Http\\Controllers\\Client\\DataController')
                ->orderAction($request, $request->integer('id'));
        }

        try {
            $controller = app('App\Http\Controllers\Client\DataController');
            $map = [
                'Order-newOrder' => 'createOrder',
                'Service-confirmService' => 'confirmService',
                'Coupon-checkExistCoupon' => 'checkCoupon',
                'Order-getFbIdFromLink' => 'getFacebookId',
                'Account-changeEmailPhone' => 'updateInformation',
                'Account-changePassword' => 'updatePassword',
                'Account-changeApiKey' => 'generateApiKey',
                'Account-enableGGAuth' => 'twoFaApprove',
                'Account-disableGGAuth' => 'twoFaDisable',
                'Panel-createChildPanel' => 'createChildPanel',
                'Payment-history' => 'paymentHistory',
                'Payment-getInvoice' => 'getPaymentInvoice',
                'Order-viewLoop' => 'viewLoop',
            ];

            if ($action === 'Product-buyProduct') {
                $response = $controller->createOrderProduct($request, $request->integer('id'));
                $payload = $response->getData(true);

                if (($payload['status'] ?? null) !== 'success') {
                    return response()->json([
                        'error' => $payload['message'] ?? 'Unable to create product order',
                    ]);
                }

                return response()->json([
                    'success' => $payload['message'] ?? 'Order successfully',
                    'order_id' => $payload['order_id'] ?? null,
                    'charge' => $payload['charge'] ?? null,
                    'redirect' => $payload['redirect'] ?? null,
                ]);
            }

            if ($action === 'Ticket-reportOrder') {
                $request->merge(['type' => $request->input('request')]);
                return $controller->orderReport($request, $request->integer('order_id'));
            }

            if (isset($map[$action])) {
                if ($action === 'Order-newOrder') {
                    $this->normalizeLegacyOrderRequest($request);
                }

                if ($action === 'Account-changePassword') {
                    $request->merge([
                        'current_password' => $request->input('current_password', $request->input('oldp')),
                        'password' => $request->input('password', $request->input('newp')),
                        'password_confirmation' => $request->input('password_confirmation', $request->input('cnewp')),
                    ]);
                }

                $response = $controller->{$map[$action]}($request);

                if ($action === 'Account-changeApiKey' && $response instanceof \Illuminate\Http\JsonResponse) {
                    $payload = $response->getData(true);

                    if ($payload['success'] ?? false) {
                        return response()->json([
                            'success' => $payload['api_key'] ?? '',
                            'message' => $payload['message'] ?? null,
                        ]);
                    }

                    return response()->json([
                        'error' => $payload['message'] ?? 'Unable to generate API key',
                    ]);
                }

                if (in_array($action, [
                    'Account-changeEmailPhone',
                    'Account-changePassword',
                    'Account-enableGGAuth',
                    'Account-disableGGAuth',
                ], true) && $response instanceof \Illuminate\Http\JsonResponse) {
                    $payload = $response->getData(true);

                    if (!($payload['success'] ?? false)) {
                        return response()->json([
                            'error' => $payload['message'] ?? 'Unable to update account settings',
                            'language' => $payload['message'] ?? null,
                        ]);
                    }

                    return response()->json([
                        'success' => true,
                        'message' => $payload['message'] ?? 'Updated successfully',
                        'language' => $payload['message'] ?? null,
                    ]);
                }

                // app.ajax() expects legacy business errors in a successful HTTP
                // response and decides success by checking the `error` key.
                if ($action === 'Order-newOrder' && $response instanceof \Illuminate\Http\JsonResponse) {
                    $payload = $response->getData(true);
                    if (!($payload['success'] ?? false)) {
                        return response()->json([
                            'error' => $payload['message'] ?? collect($payload['errors'] ?? [])->flatten()->first() ?? 'Unable to create order',
                            'message' => $payload['message'] ?? null,
                            'errors' => $payload['errors'] ?? null,
                        ]);
                    }

                    return response()->json([
                        'success' => $payload['message'] ?? 'Order successfully',
                        'message' => $payload['message'] ?? 'Order successfully',
                        'order_id' => $payload['order_id'] ?? data_get($payload, 'data.order.id'),
                        'data' => $payload['data'] ?? null,
                    ]);
                }

                if ($action === 'Panel-createChildPanel' && $response instanceof \Illuminate\Http\JsonResponse) {
                    $payload = $response->getData(true);

                    if (!($payload['success'] ?? false)) {
                        return response()->json([
                            'error' => $payload['message'] ?? collect($payload['errors'] ?? [])->flatten()->first()
                                ?? 'Unable to create child panel',
                            'message' => $payload['message'] ?? null,
                            'errors' => $payload['errors'] ?? null,
                        ]);
                    }

                    return response()->json([
                        'success' => $payload['message'] ?? 'Child panel created successfully',
                        'message' => $payload['message'] ?? 'Child panel created successfully',
                        'data' => $payload['data'] ?? null,
                    ]);
                }

                return $response;
            }
            if ($entity === 'Account' && in_array($method, ['changeLanguage', 'changeCurrency', 'loadNote', 'saveNote'], true)) {
                return $this->dispatchAccount($method, $request);
            }

            return response()->json(['error' => "Unsupported client action: {$action}"], 404);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function normalizeLegacyOrderRequest(Request $request): void
    {
        $legacy = $request->all();
        $normalized = [
            'service' => $request->input('service', $request->input('sid')),
            'mediaUrl' => $request->input('mediaUrl', $request->input('media')),
        ];

        if ((int) $request->input('loop') > 0) {
            $normalized['loop_quantity'] = (int) $request->input('loop');
            if ((int) $request->input('loop_spacing') > 0) {
                $normalized['loop_spacing'] = (int) $request->input('loop_spacing');
            }
        } else {
            unset($legacy['loop_quantity'], $legacy['loop_spacing']);
        }

        if (!$request->boolean('schedule')) {
            unset($legacy['schedule_time']);
        }

        $request->replace(array_merge($legacy, array_filter(
            $normalized,
            static fn ($value) => $value !== null && $value !== ''
        )));
    }

    private const CONTROLLERS = [
        // Legacy admin.js uses the Payment entity for payment-method actions.
        'Payment' => 'Admin\PaymentMethodController',
        'Setting' => 'Admin\SettingController',
        'Provider' => 'Admin\ApiProviderController',
        'Order' => 'Admin\OrderController',
        'Category' => 'Admin\CategoryController',
        'Platform' => 'Admin\CategoryController',
        'Service' => 'Admin\ServiceController',
        'Account' => 'Admin\AccountController',
        'Transaction' => 'Admin\AccountController',
        'CustomService' => 'Admin\AccountController',
        'Ticket' => 'Admin\TicketController',
        'Message' => 'Admin\TicketController',
        'Product' => 'Admin\ProductController',
        'ProductOrder' => 'Admin\ProductController',
        'Analytic' => 'Admin\AnalyticsController',
        'Affiliate' => 'Admin\AffiliateController',
        'Refill' => 'Admin\RefillCancelController',
        'RefillProduct' => 'Admin\RefillCancelController',
        'Cancel' => 'Admin\RefillCancelController',
        'News' => 'Admin\NewsController',
        'TicketSubject' => 'Admin\TicketSubjectController',
        'ChildPanel' => 'Admin\ChildPanelController',
    ];

    private const METHOD_MAPS = [
        'Setting' => [
            'loadHTML' => 'loadHTML',
            'saveHTML' => 'saveHTML',
            'defaultHTML' => 'defaultHTML',
            'loadSignInHTML' => 'loadSignInHTML',
            'saveSignInHTML' => 'saveSignInHTML',
            'saveSetting' => 'saveSetting',
            'updateSetting' => 'saveSetting',
            'updateCustomCss' => 'saveSetting',
            'saveCustomCss' => 'saveSetting',
            'uploadFavicon' => 'uploadLogo',
            'uploadLogo' => 'uploadLogo',
            'uploadLogoSquare' => 'uploadLogo',
            'uploadLogoFacebook' => 'uploadLogo',
            'updateCurrency' => 'updateCurrency',
            'loadLanguage' => 'loadLanguageData',
            'saveLanguage' => 'createLanguage',
            'deleteLanguage' => 'deleteLanguage',
            'unlockIP' => 'unblockIp',
            'testSmtp' => 'testSmtp',
            'enableModule' => 'enableModule',
            'updateMemberLevel' => 'updateMemberLevel',
        ],
        'Payment' => [
            'getMethod' => 'getMethod',
            'add' => 'store',
            'addMethod' => 'store',
            'update' => 'updateFromRequest',
            'updateMethod' => 'updateFromRequest',
            'delete' => 'destroyFromRequest',
            'updateStatusMethod' => 'toggleStatusFromRequest',
            'sortMethods' => 'sortFromRequest',
            'getGroup' => 'getGroupFromRequest',
            'addGroup' => 'storeGroupFromRequest',
            'updateGroup' => 'updateGroupFromRequest',
            'deleteGroup' => 'deleteGroupFromRequest',
            'historyFund' => 'historyData',
            'historyFull' => 'historyData',
        ],
        'Provider' => [
            'list' => 'list',
            'get' => 'show',
            'add' => 'store',
            'update' => 'update',
            'delete' => 'destroy',
            'getBalance' => 'getBalance',
            'checkBalance' => 'getBalance',
            'syncAll' => 'syncAllBalances',
            'toggle' => 'toggleStatus',
            'sort' => 'sort',
            'products' => 'products',
            'services' => 'ajaxProviderServices',
            'syncFor1dg' => 'syncFor1dg',
            'checkOfNMH' => 'checkOfNMH',
        ],
        'Order' => [
            'list' => 'list',
            'listOld' => 'listOld',
            'get' => 'get',
            'changeStatus' => 'changeStatus',
            'bulkChangeStatus' => 'bulkChangeStatus',
            'addTag' => 'addTag',
            'addNote' => 'addNote',
            'addStartCount' => 'addStartCount',
            'addProviderOrderID' => 'addProviderOrderID',
            'sendOrder' => 'sendOrder',
            'changeStatusFromApi' => 'changeStatusFromApi',
            'statsOrder' => 'statsOrder',
            'editOrderOld' => 'editOrderOld',
            'export' => 'exportOrders',
        ],
        'Category' => [
            'add' => 'add',
            'update' => 'update',
            'updateStatus' => 'updateStatus',
            'sort' => 'sort',
            'syncFor1dg' => 'syncFor1dg',
        ],
        'Platform' => [
            'add' => 'addPlatform',
            'update' => 'updatePlatform',
            'sort' => 'sortPlatform',
        ],
        'Service' => [
            'get' => 'ajaxGet',
            'add' => 'ajaxAdd',
            'import' => 'storeImport',
            'update' => 'ajaxUpdate',
            'delete' => 'ajaxDelete',
            'sort' => 'ajaxSort',
            'updateStatus' => 'ajaxUpdateStatus',
            'syncFor1dg' => 'ajaxSyncFor1dg',
        ],
        'Ticket' => [
            'history' => 'ticketHistoryAjax', 'processing' => 'ticketProcessing',
            'done' => 'ticketDone', 'export' => 'ticketExport',
        ],
        'Message' => [
            'getUsers' => 'messageGetUsers', 'getAllChatMessages' => 'messageGetAll',
            'getUserChatMessages' => 'messageGetNew', 'send' => 'messageSend',
        ],
        'Account' => [
            'select2' => 'searchUsers',
            'select2ForEmailUsername' => 'searchUsers',
            'listAccount' => 'list',
            'create' => 'store',
            'addAccount' => 'store',
            'updateAccount' => 'updateAccount',
            'addFunds' => 'addFunds',
            'statsFund' => 'statsFund',
        ],
        'Product' => [
            'add' => 'store',
            'update' => 'updateFromRequest',
            'copyProduct' => 'copyProduct',
            'addCategory' => 'storeCategory',
            'updateCategory' => 'updateCategory',
            'addGroup' => 'storeGroup',
            'sortCategory' => 'sortCategory',
            'sortProduct' => 'sortProduct',
            'addWareHouse' => 'storeWarehouse',
            'sortWarehouse' => 'sortWarehouse',
            'addGoods' => 'addGoods',
            'downloadGoods' => 'downloadGoods',
            'deleteGoods' => 'deleteGoods',
            'syncFor1dg' => 'syncFor1dg',
        ],
        'ProductOrder' => [
            'list' => 'productOrderList', 'get' => 'productOrderGet',
            'changeStatus' => 'productOrderChangeStatus', 'addNote' => 'productOrderAddNote',
            'getResult' => 'productOrderGetResult', 'getRequire' => 'productOrderGetRequire',
            'subOrder' => 'productOrderSubOrder', 'changeStatusFromApi' => 'productOrderUnsupported',
            'sendServiceOrder' => 'productOrderUnsupported', 'changeServiceCombo' => 'productOrderUnsupported',
            'sendComboService' => 'productOrderUnsupported', 'export' => 'productOrderExport',
        ],
        'Analytic' => [
            'account' => 'account',
            'order' => 'order',
            'service' => 'service',
            'top10Services' => 'top10Services',
            'top10UsersCharge' => 'top10UsersCharge',
            'summary' => 'summary',
        ],
        'Affiliate' => [
            'list' => 'list',
            'approve' => 'approve',
        ],
        'Refill' => [
            'list' => 'refillList', 'get' => 'refillGet',
            'changeStatus' => 'refillChangeStatus', 'bulkChangeStatus' => 'refillBulkChangeStatus',
        ],
        'RefillProduct' => [
            'list' => 'refillProductList', 'get' => 'refillProductGet',
            'changeStatus' => 'refillProductChangeStatus', 'bulkChangeStatus' => 'refillProductBulkChangeStatus',
            'completed' => 'refillProductCompleted', 'getResult' => 'refillProductGetResult',
        ],
        'Cancel' => [
            'list' => 'cancelList', 'get' => 'cancelGet',
            'changeStatus' => 'cancelChangeStatus', 'bulkChangeStatus' => 'cancelBulkChangeStatus',
        ],
        'News' => [
            'get' => 'get', 'add' => 'add',
            'update' => 'updateFromRequest', 'deleteNews' => 'deleteNews',
        ],
        'TicketSubject' => [
            'get' => 'getFromRequest', 'save' => 'saveFromRequest',
            'toggle' => 'toggleFromRequest', 'delete' => 'deleteFromRequest',
            'reorder' => 'reorderFromRequest',
        ],
        'ChildPanel' => [
            'update' => 'updateFromRequest',
            'updateStatus' => 'updateStatusFromRequest',
            'updateAccess' => 'updateAccessFromRequest',
            'delete' => 'destroyFromRequest',
        ],
    ];

    public function handle(Request $request)
    {
        [$entity, $method, $action] = $this->parseAction((string) $request->input('action'));

        if (!$entity || !$method) {
            return response()->json(['error' => "Invalid action: {$action}"], 400);
        }

        if ($entity === 'Account' && in_array($method, [
            'signin', 'signup', 'resetPassword', 'resendVerifyEmail', 'checkGGAuth',
        ], true)) {
            return app(\App\Http\Controllers\Auth\AuthController::class)->legacyRequest($request);
        }

        // The install page uses the same AJAX/modal pipeline as the auth pages,
        // but installation is not an Account action and must remain public.
        if ($action === 'Install-submit') {
            // app.ajax() sends form values inside the legacy `data` envelope.
            // Flatten it before passing the request to the normal installer,
            // otherwise validation sees an empty request.
            if ($request->has('data') && is_array($request->input('data'))) {
                $request->merge($request->input('data'));
            }

            $request->headers->set('Accept', 'application/json');
            return app(\App\Http\Controllers\Auth\AuthController::class)->install($request);
        }

        if ($action === 'Addfunds-createCheckout') {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please sign in to create a checkout.',
                ], 401);
            }

            if ($request->has('data') && is_array($request->input('data'))) {
                $request->merge($request->input('data'));
            }

            $request->headers->set('Accept', 'application/json');

            return app(\App\Http\Controllers\Client\ViewController::class)->createCheckout($request);
        }

        if (in_array($action, self::CLIENT_ACTIONS, true)) {
            return $this->handleClient($request);
        }

        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!isset(self::CONTROLLERS[$entity])) {
            return response()->json(['error' => "Unknown entity: {$entity}"], 404);
        }

        try {
            return $this->dispatch($entity, $method, $request);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function parseAction(string $action): array
    {
        $action = trim($action);
        if (str_starts_with($action, 'Admin-')) {
            $action = substr($action, 6);
        }

        [$entity, $method] = array_pad(explode('-', $action, 2), 2, '');

        return [$entity, $method, $action];
    }

    private function dispatch(string $entity, string $method, Request $request)
    {
        // admin.js posts form values below `data`; controllers expect normal input keys.
        if ($request->has('data') && is_array($request->input('data'))) {
            $request->merge($request->input('data'));
        }

        // The existing admin.js transaction tables use the legacy
        // `Admin-Transaction-*` action names. Transactions are account
        // ledger rows, so serve both the recent and old tables from the same
        // DataTables endpoint instead of looking for a non-existent
        // TransactionController method.
        if ($entity === 'Transaction' && in_array($method, self::ADMIN_TRANSACTION_ACTIONS, true)) {
            return app('App\\Http\\Controllers\\Admin\\AccountController')->transactionsData($request);
        }

        if ($entity === 'Account' && $method === 'changeApiKeyAdmin') {
            return app('App\Http\Controllers\Admin\ApiController')->changeKey($request);
        }

        if ($entity === 'CustomService') {
            return app(\App\Http\Controllers\Admin\AccountController::class)
                ->customRatesLegacy($method, $request);
        }

        if ($entity === 'Payment' && $method === 'addFunds') {
            return app(\App\Http\Controllers\Admin\AccountController::class)
                ->addFunds($request);
        }

        if ($entity === 'Account') {
            return $this->dispatchAccount($method, $request);
        }

        if ($entity === 'Provider' && $method === 'services') {
            return app('App\Http\Controllers\Admin\ServiceController')->ajaxProviderServicesForImport($request);
        }

        if ($entity === 'Service' && in_array($method, ['getSyncLogs', 'markReadSync'], true)) {
            return app('App\Http\Controllers\Admin\ServiceSyncLogController')->{$method}($request);
        }

        if ($entity === 'Ticket' && $method === 'report') {
            return app('App\Http\Controllers\Admin\TicketController')->report($request);
        }

        // The existing _reports script keeps the legacy Analytic-* action prefix.
        if ($entity === 'Analytic' && in_array($method, ['reports', 'paymentReports'], true)) {
            $controller = app('App\Http\Controllers\Admin\ReportController');

            return $controller->{$method}($request);
        }

        $controller = app('App\Http\Controllers\\' . self::CONTROLLERS[$entity]);
        $actualMethod = self::METHOD_MAPS[$entity][$method] ?? $method;

        if (!method_exists($controller, $actualMethod)) {
            return response()->json(['error' => "{$entity}: method '{$method}' not found"], 404);
        }

        // Action language từ admin.js gửi code trong payload thay vì tham số route.
        if ($entity === 'Setting' && in_array($actualMethod, ['loadLanguageData', 'deleteLanguage'], true)) {
            return $controller->{$actualMethod}($request, (string) $request->input('code', ''));
        }

        if ($entity === 'Setting' && $actualMethod === 'createLanguage') {
            $code = (string) $request->input('code', '');
            $groupedData = $request->input('json', []);
            if (!is_array($groupedData) || $groupedData === []) {
                return $controller->{$actualMethod}($request);
            }
            $flatData = [];
            foreach ((array) $groupedData as $section => $items) {
                foreach ((array) $items as $key => $value) {
                    $prefix = $section . '::';
                    $key = str_starts_with((string) $key, $prefix)
                        ? substr((string) $key, strlen($prefix))
                        : $key;
                    $flatData[$section === 'common' ? $key : "{$section}.{$key}"] = $value;
                }
            }

            $request->merge([
                // admin.js lấy trực tiếp từ option được chọn:
                // <option value="mc" data-icon="fi fi-mc">Monaco</option>.
                'name' => trim((string) $request->input('name', '')),
                'data' => $flatData,
                'flag' => trim((string) $request->input('flag', '')),
            ]);
        }

        return $controller->$actualMethod($request);
    }

    private function dispatchAccount(string $method, Request $request)
    {
        if (in_array($method, self::ACCOUNT_TRANSACTION_ACTIONS, true)) {
            return app('App\\Http\\Controllers\\Admin\\AccountController')->transactionsData($request);
        }

        if ($method === 'changeLanguage') {
            $lang = (string) $request->input('data.language', $request->input('language', 'vi'));
            $lang = match (strtolower($lang)) {
                'us' => 'en',
                'vn' => 'vi',
                default => strtolower($lang),
            };

            $languageExists = Language::query()
                ->where('status', true)
                ->where('code', $lang)
                ->exists();

            if (!$languageExists && !in_array($lang, ['vi', 'en'], true)) {
                return response()->json(['error' => 'Invalid language'], 400);
            }

            $user = Auth::user();
            if ($user) {
                $user->update(['lang' => $lang]);
            }

            session(['language' => $lang]);

            return response()->json(['success' => true]);
        }

        if ($method === 'changeCurrency') {
            $currency = (string) $request->input('data.currency', $request->input('currency', 'USD'));
            $currencyExists = Currency::query()
                ->where('status', true)
                ->where('code', $currency)
                ->exists();

            if (!$currencyExists) {
                return response()->json(['error' => 'Invalid currency'], 400);
            }

            $user = Auth::user();
            if ($user) {
                $user->update(['currency' => $currency]);
            }

            return response()->json(['success' => true]);
        }

        if ($method === 'changeTimezone') {
            $timezone = (string) $request->input('data.timezone', $request->input('timezone', '0'));
            $validTimezones = getTimezones();

            if (!in_array($timezone, array_column($validTimezones, 'timezone'), true)) {
                return response()->json(['error' => 'Invalid timezone'], 400);
            }

            $user = Auth::user();
            if ($user) {
                $user->update(['timezone' => $timezone]);
            }

            return response()->json(['success' => true]);
        }

        if ($method === 'loadNote') {
            return response()->json(['success' => null]);
        }

        if ($method === 'saveNote') {
            return response()->json(['success' => true]);
        }

        $controller = app('App\Http\Controllers\\' . self::CONTROLLERS['Account']);
        $actualMethod = self::METHOD_MAPS['Account'][$method] ?? null;

        if ($actualMethod === null || !method_exists($controller, $actualMethod)) {
            return response()->json(['error' => "Account: method '{$method}' not found"], 404);
        }

        return $controller->$actualMethod($request);
    }
}
