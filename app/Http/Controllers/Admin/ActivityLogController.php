<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display all activity logs
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'type' => ['nullable', 'string', 'max:100'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'search' => ['nullable', 'string', 'max:100'],
            'date' => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        // Select only the columns used by the activity page to avoid loading
        // potentially large metadata columns for every row.
        $query = ActivityLog::query()
            ->select(['id', 'user_id', 'type', 'activity', 'created_at'])
            ->with('user:id,name,email,username')
            ->orderByDesc('id');

        // Filter by specific type
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        // Filter by user
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        // Search functionality
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('activity->ip_address', 'like', "%{$search}%")
                  ->orWhere('activity->user_agent', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by date
        if (!empty($filters['date'])) {
            $query->whereDate('created_at', $filters['date']);
        }

        $logs = $query->paginate($filters['per_page'] ?? 50)->withQueryString();

        return view('admin.activity.index', compact('logs'));
    }
}
