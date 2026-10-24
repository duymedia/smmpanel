<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\ServiceSyncLog;
use Illuminate\Http\Request;

class ServiceSyncLogController extends Controller
{
    /**
     * Legacy AJAX response consumed by _service_sync_logs in admin.js.
     */
    public function getSyncLogs(Request $request)
    {
        $query = ServiceSyncLog::with('service')
            ->forDomain()
            ->latest('id');

        if (\Schema::hasColumn('service_sync_logs', 'log_type')) {
            $query->where('log_type', 'api');
        }

        if ($request->input('unread') !== null && $request->input('unread') !== '') {
            $query->where('is_read', (bool) ((int) $request->input('unread')));
        }
        if ($request->filled('provider_id')) {
            $query->where('provider_id', (int) $request->input('provider_id'));
        }
        if ($request->filled('service_id')) {
            $query->where('service_id', (int) $request->input('service_id'));
        }

        $this->applyLegacyEventFilter($query, (string) $request->input('event_type', ''));

        return response()->json($query->limit(2000)->get()->map(function (ServiceSyncLog $log) {
            $eventType = $this->legacyEventType($log);
            $oldValue = $this->formatValue($log->old_value);
            $newValue = $this->formatValue($log->new_value);
            $description = match ($eventType) {
                'new' => 'New service detected',
                'disabled' => 'DISABLED Service ' . ($log->service_api ?: $log->service_id)
                    . ' of provider: ' . ($log->provider_name ?: 'Unknown provider'),
                'refill' => 'Refill changed from ' . $oldValue . ' to ' . $newValue,
                'cancel' => 'Cancel changed from ' . $oldValue . ' to ' . $newValue,
                default => ucfirst(str_replace('_', ' ', (string) ($log->field_changed ?: $log->change_type)))
                    . ' from ' . $oldValue . ' to ' . $newValue,
            };

            return [
                'id' => $log->id,
                'provider_id' => $log->provider_id,
                'provider_name' => e($log->provider_name ?: 'Unknown provider'),
                'service_id' => $log->service_id,
                'provider_sid' => e($log->service_api ?: ''),
                'service_name' => e($log->service?->getName() ?: ''),
                'event_type' => $eventType,
                // admin.js uses 0 for unread and 1 for reviewed.
                'unread' => $log->is_read ? 1 : 0,
                'log' => e($description),
                'created' => optional($log->created_at)->format('Y-m-d H:i:s'),
            ];
        })->values());
    }

    /**
     * type=1 marks every log as read; type=0 marks the supplied id only.
     */
    public function markReadSync(Request $request)
    {
        if ((int) $request->input('type') === 1) {
            $count = ServiceSyncLog::markAllRead(getDomain());
        } else {
            $count = ServiceSyncLog::forDomain()
                ->whereKey((int) $request->input('id'))
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return response()->json(['success' => true, 'count' => $count]);
    }

    private function applyLegacyEventFilter($query, string $eventType): void
    {
        match ($eventType) {
            'price_up' => $query->where('change_type', 'price_increase'),
            'price_down' => $query->where('change_type', 'price_decrease'),
            'minmax' => $query->where(function ($q) {
                $q->where('change_type', 'min_max_change')
                    ->orWhereIn('field_changed', ['min', 'max']);
            }),
            'refill' => $query->where('field_changed', 'refill'),
            'cancel' => $query->where('field_changed', 'cancel'),
            'disabled' => $query->where('change_type', 'disable')->where('field_changed', 'status'),
            'new' => $query->whereIn('change_type', ['new', 'created', 'service_created']),
            default => null,
        };
    }

    private function legacyEventType(ServiceSyncLog $log): string
    {
        if ($log->field_changed === 'refill') return 'refill';
        if ($log->field_changed === 'cancel') return 'cancel';

        return match ($log->change_type) {
            'price_increase' => 'price_up',
            'price_decrease' => 'price_down',
            'min_max_change' => 'minmax',
            'disable' => 'disabled',
            'new', 'created', 'service_created' => 'new',
            default => 'minmax',
        };
    }

    private function formatValue($value): string
    {
        if ($value === null || $value === '') return '-';
        if (!is_numeric($value)) return (string) $value;

        return rtrim(rtrim(number_format((float) $value, 6, '.', ''), '0'), '.');
    }

    public function index(Request $request)
    {
        $query = ServiceSyncLog::with(['service'])
            ->forDomain()
            ->orderBy('id', 'desc');

        if (\Schema::hasColumn('service_sync_logs', 'log_type')) {
            $query->where('log_type', 'api');
        }

        $logs        = $query->paginate(50);
        $unreadCount = ServiceSyncLog::forDomain()->unread()->count();
        $providers   = ApiProvider::orderBy('name')->pluck('name', 'id');

        return view('admin.service_sync_logs.index', compact('logs', 'unreadCount', 'providers'));
    }

    public function data(Request $request)
    {
        $query = ServiceSyncLog::with(['service'])
            ->forDomain()
            ->orderBy('id', 'desc');

        if ($request->filled('change_type')) {
            $query->where('change_type', $request->change_type);
        }
        if ($request->filled('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }
        if ($request->filled('is_read') && $request->is_read !== '') {
            $query->where('is_read', (bool) $request->is_read);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        // Luôn filter log_type nếu cột tồn tại
        if (\Schema::hasColumn('service_sync_logs', 'log_type')) {
            $query->where('log_type', $request->input('log_type', 'api'));
        }

        $logs        = $query->paginate(50);
        $unreadCount = ServiceSyncLog::forDomain()->unread()->count();

        $items = $logs->map(fn ($log) => [
            'id'            => $log->id,
            'service_id'    => $log->service_id,
            'provider_name' => $log->provider_name,
            'service_api'   => $log->service_api,
            'service_name'  => $log->service?->getName(),
            'change_type'   => $log->change_type,
            'field_changed' => $log->field_changed,
            'old_value'     => $log->old_value,
            'new_value'     => $log->new_value,
            'is_read'       => $log->is_read,
            'created_at'    => $log->created_at->format('Y-m-d H:i:s'),
        ]);

        return response()->json([
            'items'        => $items,
            'unreadCount'  => $unreadCount,
            'total'        => $logs->total(),
            'from'         => $logs->firstItem() ?? 0,
            'to'           => $logs->lastItem() ?? 0,
            'last_page'    => $logs->lastPage(),
            'current_page' => $logs->currentPage(),
        ]);
    }

    public function markRead(Request $request)
    {
        $count = ServiceSyncLog::markAllRead(getDomain());

        return response()->json(['success' => true, 'count' => $count]);
    }

    public function markOne(Request $request, ServiceSyncLog $log)
    {
        $log->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
