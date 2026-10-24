<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildPanel;
use App\Models\User;
use App\Library\CloudflareCustom;
use App\Library\CpanelCustom;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ChildPanelController extends Controller
{
    /**
     * Display list of child panels
     */
    public function index(Request $request): View
    {
        $currentDomain = strtolower(trim(getDomain()));
        $filters = $request->validate([
            'status' => ['nullable', 'in:pending,completed,suspended'],
            'domain' => ['nullable', 'string', 'max:255'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);
        $query = ChildPanel::with('user')
            // A parent domain must only see the child panels it owns.
            ->whereRaw('LOWER(domain) = ?', [$currentDomain])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by domain
        if (!empty($filters['domain'])) {
            $domainFilter = strtolower(trim($filters['domain']));
            $query->where(function ($domainQuery) use ($domainFilter): void {
                $domainQuery
                    ->whereRaw('LOWER(domain_panel) LIKE ?', ['%' . $domainFilter . '%'])
                    ->orWhereRaw('LOWER(domain) LIKE ?', ['%' . $domainFilter . '%']);
            });
        }

        // Filter by user
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        $childPanels = $query->paginate($filters['per_page'] ?? 15)->withQueryString();
        $statuses = ['pending', 'completed', 'suspended'];
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        $accessPages = [
            'orders' => 'Đơn hàng dịch vụ',
            'product_orders' => 'Đơn hàng sản phẩm',
            'refill_services' => 'Bảo hành dịch vụ',
            'refill_products' => 'Bảo hành sản phẩm',
            'cancel_services' => 'Hủy dịch vụ',
            'accounts' => 'Tài khoản khách hàng',
            'services' => 'Dịch vụ',
            'categories' => 'Danh mục dịch vụ',
            'products' => 'Sản phẩm',
            'providers' => 'Nhà cung cấp',
            'payments' => 'Thanh toán',
            'messages' => 'Tin nhắn',
            'tickets' => 'Phiếu hỗ trợ',
            'news' => 'Thông báo',
            'coupons' => 'Mã giảm giá',
            'reports' => 'Báo cáo',
            'analytics' => 'Phân tích',
            'affiliates' => 'Tiếp thị liên kết',
            'api' => 'API',
            'settings' => 'Cài đặt',
            'service_sync_logs' => 'Nhật ký đồng bộ dịch vụ',
            'activity' => 'Nhật ký hoạt động',
            'backup' => 'Sao lưu',
            'child-panels' => 'Quản lý website con',
        ];

        // Pages introduced by the reworked navbar (see t.html).
        $accessPages['ticket_statistics_by_service'] = 'Ticket statistics by service';
        $accessPages['api_v2'] = 'API v2';
        $childNavbarPages = [
            'orders', 'refill_services', 'cancel_services', 'accounts',
            'services', 'categories', 'payments', 'coupons', 'messages',
            'tickets', 'news', 'ticket_statistics_by_service', 'settings',
            'analytics', 'reports', 'affiliates', 'api', 'api_v2', 'backup',
        ];
        $childPanelAccessPages = array_intersect_key($accessPages, array_flip($childNavbarPages));
        // Render every available page in the modal so ALL and Child panel are
        // visibly different selections. The restricted set is applied by the
        // Child panel quick option in admin.js and by the middleware.
        // Keep the full list in the modal so the two quick options are visibly
        // different; the restricted list above is used for the default child
        // package and by the JavaScript quick option.

        $childPanels->getCollection()->transform(function (ChildPanel $panel) use ($currentDomain, $childPanelAccessPages): ChildPanel {
            $access = $panel->access;
            $accessList = is_string($access) ? json_decode($access, true) : $access;
            // The model default is "child". Treat it as the standard child
            // admin area instead of trying to decode it as JSON.
            if ($access === 'child') {
                $accessList = array_keys($childPanelAccessPages);
            }
            $panel->access_list = is_array($accessList) ? $accessList : [];
            $panel->is_access_all = $access === 'all' || $accessList === ['all'];
            $panel->panel_domain = strtolower(trim((string) $panel->domain_panel));
            $panel->parent_domain = strtolower(trim((string) $panel->domain));
            $panel->is_current_domain = $panel->parent_domain !== '' && $panel->parent_domain === $currentDomain;
            $panel->status_color = match ($panel->status) {
                'completed' => 'success',
                'suspended' => 'danger',
                default => 'warning',
            };

            return $panel;
        });

        return view('admin.child_panels.index', compact('childPanels', 'statuses', 'users', 'accessPages', 'currentDomain'));
    }

    /**
     * Show child panel details
     */
    public function show(ChildPanel $childPanel): View
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        $childPanel->load('user');
        $settings = $childPanel->settings ?? [];

        return view('admin.child-panels.show', compact('childPanel', 'settings'));
    }

    /**
     * Update child panel status
     */
    public function updateStatus(Request $request, ChildPanel $childPanel): JsonResponse
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        $request->validate([
            'status' => 'required|in:pending,completed,suspended'
        ]);

        $childPanel->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => adminMessage('status'),
            'status' => $childPanel->status
        ]);
    }


    public function update(Request $request, ChildPanel $childPanel): JsonResponse
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        $data = $request->validate([
            'domain_panel' => ['nullable', 'string', 'max:255'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'in:pending,completed,suspended'],
            'expires_at' => ['nullable', 'date'],
        ]);

        if (array_key_exists('domain_panel', $data)) {
            $domain = strtolower(trim((string) $data['domain_panel']));
            $data['domain_panel'] = $domain;
        }

        if (!empty($data['expires_at'])) {
            $data['expires_at'] = Carbon::parse($data['expires_at']);
        }

        $childPanel->update($data);

        return response()->json([
            'success' => true,
            'message' => adminMessage('update'),
            'panel' => $childPanel->fresh()->load('user'),
        ]);
    }

    public function updateFromRequest(Request $request): JsonResponse
    {
        return $this->update($request, $this->findFromRequest($request));
    }

    public function updateStatusFromRequest(Request $request): JsonResponse
    {
        return $this->updateStatus($request, $this->findFromRequest($request));
    }

    public function updateAccessFromRequest(Request $request): JsonResponse
    {
        return $this->updateAccess($request, $this->findFromRequest($request));
    }

    public function destroyFromRequest(Request $request): JsonResponse
    {
        return $this->destroy($request, $this->findFromRequest($request));
    }

    public function findFromRequest(Request $request): ChildPanel
    {
        return ChildPanel::whereRaw('LOWER(domain) = ?', [strtolower(trim(getDomain()))])
            ->findOrFail((int) $request->input('id'));
    }

    /** Update the admin pages available to a child panel. */
    public function updateAccess(Request $request, ChildPanel $childPanel): JsonResponse
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        $data = $request->validate([
            'access' => ['required'],
            'access.*' => ['string', 'max:80'],
        ]);

        $access = $data['access'];
        if ($access === 'all' || (is_array($access) && in_array('all', $access, true))) {
            $access = 'all';
        } else {
            $access = array_values(array_unique(array_filter(
                is_array($access) ? $access : [$access],
                static fn ($page) => is_string($page) && $page !== 'all'
            )));
            $access = json_encode($access, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
        }

        $childPanel->update(['access' => $access]);

        return response()->json([
            'success' => true,
            'message' => adminMessage('update'),
            'access' => $access,
        ]);
    }

    /**
     * Approve child panel (change status to completed)
     */
    public function approve(ChildPanel $childPanel): JsonResponse
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        $childPanel->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => adminMessage('status')
        ]);
    }

    /**
     * Suspend child panel
     */
    public function suspend(ChildPanel $childPanel): JsonResponse
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        $childPanel->update(['status' => 'suspended']);

        return response()->json([
            'success' => true,
            'message' => adminMessage('status')
        ]);
    }

    /**
     * Delete child panel with Cloudflare and cPanel domain deletion
     */
    public function destroy(Request $request, ChildPanel $childPanel): JsonResponse
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        try {
            $zoneId = $request->input('zone_id');
            $domainName = $childPanel->domain_panel;
            
            // Initialize Cloudflare and cPanel
            $cloudflare = new CloudflareCustom();
            $cpanel = new CpanelCustom();
            
            // Check if Cloudflare is configured
            $cfConfigStatus = $cloudflare->getConfigStatus();
            if (!$cfConfigStatus['is_configured']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cloudflare is not properly configured. Missing fields: ' . implode(', ', $cfConfigStatus['missing_fields'])
                ], 400);
            }
            
            // Check if cPanel is configured
            $cpConfigStatus = $cpanel->getConfigStatus();
            if (!$cpConfigStatus['is_configured']) {
                return response()->json([
                    'success' => false,
                    'message' => 'cPanel is not properly configured. Missing fields: ' . implode(', ', $cpConfigStatus['missing_fields'])
                ], 400);
            }
            
            // If zone_id not provided, try to find it from domain name
            if (empty($zoneId) && !empty($domainName)) {
                $findResult = $cloudflare->getZoneIdByDomain($domainName);
                
                if ($findResult['status'] !== 'success') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Could not find Cloudflare zone for domain: ' . $findResult['message'],
                        'error_details' => $findResult
                    ], 400);
                }
                
                $zoneId = $findResult['zone_id'];
            }
            
            // Delete from Cloudflare if zone_id exists
            if (!empty($zoneId)) {
                $cfResult = $cloudflare->deleteDomain($zoneId);
                
                if ($cfResult['status'] !== 'success') {
                    $errorMessage = $cfResult['message'] ?? 'Unknown error from Cloudflare API';
                    
                    if (isset($cfResult['data']) && is_array($cfResult['data'])) {
                        $errorDetails = [];
                        if (isset($cfResult['data']['errors']) && is_array($cfResult['data']['errors'])) {
                            foreach ($cfResult['data']['errors'] as $error) {
                                $errorDetails[] = $error['message'] ?? 'Unknown error';
                            }
                        }
                        if (!empty($errorDetails)) {
                            $errorMessage .= ' (' . implode('; ', $errorDetails) . ')';
                        }
                    }
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to delete domain from Cloudflare: ' . $errorMessage,
                        'error_details' => $cfResult
                    ], 400);
                }
                
            }
            
            // Delete from cPanel
            if (!empty($domainName)) {
                $cpResult = $cpanel->deleteDomain($domainName);
                
                // Check if cPanel deletion was successful
                if (!isset($cpResult['cpanelresult']['status']) || $cpResult['cpanelresult']['status'] != 1) {
                    $errorMessage = $cpResult['cpanelresult']['statusmsg'] ?? 'Unknown error from cPanel API';
                    
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to delete domain from cPanel: ' . $errorMessage,
                        'error_details' => $cpResult
                    ], 400);
                }
                
            }
            
            // Delete child panel from database only after successful Cloudflare and cPanel deletion
            $childPanel->delete();

            return response()->json([
                'success' => true,
                'message' => adminMessage('delete')
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting child panel: ' . $e->getMessage(),
                'error_code' => get_class($e)
            ], 500);
        }
    }

    /**
     * Create domain panel via cPanel
     */
    public function createDomain(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'domain' => 'required|string|regex:/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/'
            ]);

            $domain = strtolower(trim((string) $request->input('domain')));
            
            // Initialize cPanel
            $cpanel = new CpanelCustom();
            
            // Check if cPanel is configured
            $configStatus = $cpanel->getConfigStatus();
            if (!$configStatus['is_configured']) {
                return response()->json([
                    'success' => false,
                    'message' => 'cPanel is not properly configured. Missing fields: ' . implode(', ', $configStatus['missing_fields'])
                ], 400);
            }
            
            // Create domain in cPanel
            $cpanelResult = $cpanel->createDomain($domain);
            
            // Check if cPanel creation was successful
            if (!isset($cpanelResult['cpanelresult']['status']) || $cpanelResult['cpanelresult']['status'] != 1) {
                $errorMessage = $cpanelResult['cpanelresult']['statusmsg'] ?? 'Unknown error from cPanel API';
                
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create domain in cPanel: ' . $errorMessage,
                    'error_details' => $cpanelResult
                ], 400);
            }
            
            return response()->json([
                'success' => true,
                'message' => adminMessage('add'),
                'data' => [
                    'domain' => $domain,
                    'status' => 'created'
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid domain format: ' . implode(', ', $e->errors()['domain'] ?? ['Unknown error'])
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating domain panel: ' . $e->getMessage(),
                'error_code' => get_class($e)
            ], 500);
        }
    }

    /**
     * Get child panel settings
     */
    public function getSettings(ChildPanel $childPanel): JsonResponse
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        return response()->json([
            'success' => true,
            'settings' => $childPanel->settings ?? []
        ]);
    }

    /**
     * Update child panel settings
     */
    public function updateSettings(Request $request, ChildPanel $childPanel): JsonResponse
    {
        abort_if(strtolower(trim((string) $childPanel->domain)) !== strtolower(trim(getDomain())), 404);
        $settings = $childPanel->settings ?? [];
        $settings = array_merge($settings, $request->all());
        
        $childPanel->update(['settings' => $settings]);

        return response()->json([
            'success' => true,
            'message' => adminMessage('update'),
            'settings' => $childPanel->settings
        ]);
    }
}
