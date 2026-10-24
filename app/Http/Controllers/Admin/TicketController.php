<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class TicketController extends Controller
{
    public function report(Request $request)
    {
        $data = $request->validate([
            'start' => ['required', 'date'],
            'end' => ['required', 'date', 'after_or_equal:start'],
        ]);

        $rows = DB::table('orders')
            ->where('domain', getDomain())
            ->whereNotNull('ticket')
            ->whereBetween('created_at', [$data['start'], $data['end']])
            ->select('service_id', 'ticket', DB::raw('COUNT(*) AS total'))
            ->groupBy('service_id', 'ticket')
            ->orderBy('service_id')
            ->get()
            ->map(function ($row) {
                $ticket = strtolower(trim((string) $row->ticket));
                $type = str_contains($ticket, 'cancel') ? 1
                    : (str_contains($ticket, 'refill') ? 2
                    : (str_contains($ticket, 'speed') ? 3 : null));

                return $type ? [
                    'service_id' => (string) $row->service_id,
                    'ticket_request' => $type,
                    'total' => (int) $row->total,
                ] : null;
            })
            ->filter()
            ->values();

        return response()->json($rows);
    }

    /**
     * Ticket statistics by service (horizontal bar chart: Cancel, Refill, Speed up)
     */
    public function ticketStatisticsByService(Request $request)
    {
        return view('admin.ticket_statistics_by_service.index');
    }

    /**
     * Display order tickets list (grouped by service)
     */
    public function ticketList(): View
    {
        $ticketOrders = DB::table('orders')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('services', 'orders.service_id', '=', 'services.id')
            ->whereNotNull('orders.ticket')
            ->where('orders.ticket', '!=', '')
            ->where('orders.domain', getDomain())
            ->where(function ($query) {
                $query->whereNull('orders.ticket_status')
                    ->orWhere('orders.ticket_status', 'processing');
            })
            ->select(
                'orders.id',
                'orders.service_id',
                'orders.ticket',
                'orders.ticket_status',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
                'orders.note',
                DB::raw("COALESCE(users.username, CONCAT('User #', orders.user_id)) as username"),
                'services.name as service_name',
                DB::raw("COALESCE(services.provider_name, orders.provider_name, 'Manual') as provider_name"),
                DB::raw("COALESCE(services.provider_id, orders.provider_id, 0) as provider_id")
            )
            ->orderBy('orders.created_at', 'desc')
            ->get()
            ->map(function ($order) {
                if ($order->service_name) {
                    $decoded = json_decode($order->service_name, true);
                    if (is_array($decoded)) {
                        $order->service_name = $decoded['en'] ?? $decoded[array_key_first($decoded)] ?? $order->service_name;
                    }
                }
                $order->ticket_status = $order->ticket_status ?? null;
                $ticket = strtolower((string) $order->ticket);
                $order->ticket_label = str_contains($ticket, 'cancel') ? 'Hủy' : (str_contains($ticket, 'refill') ? 'Bảo hành' : 'Tăng tốc');
                $order->ticket_color = str_contains($ticket, 'cancel') ? 'warning' : (str_contains($ticket, 'refill') ? 'info' : 'primary');
                return $order;
            })
            ->groupBy('provider_id');

        $baseQuery = DB::table('orders')->whereNotNull('ticket')->where('ticket', '!=', '')->where('domain', getDomain());
        $stats = [
            'waiting'    => (clone $baseQuery)->whereNull('ticket_status')->count(),
            'processing' => (clone $baseQuery)->where('ticket_status', 'processing')->count(),
        ];

        return view('admin.tickets.index', compact('ticketOrders', 'stats'));
    }

    /**
     * Update ticket_status for order tickets
     * type: 0 = by provider_id, 1 = by service_id, 2 = by order_id
     */
    public function updateTicketStatus(Request $request)
    {
        $request->validate([
            'type'   => 'required|in:0,1,2',
            'id'     => 'required|integer',
            'status' => 'required|in:processing,done,completed',
        ]);

        $query = DB::table('orders')->whereNotNull('ticket')->where('ticket', '!=', '')->where('domain', getDomain());

        switch ((int) $request->type) {
            case 0:
                $query->where('provider_id', $request->id);
                break;
            case 1:
                $query->where('service_id', $request->id);
                break;
            case 2:
                $query->where('id', $request->id);
                break;
        }

        $query->update(['ticket_status' => $request->status === 'done' ? 'completed' : $request->status]);

        return response()->json(['success' => true]);
    }

    /**
     * Display tickets list for admin
     */
    public function index(): View
    {
        return view('admin.messages.index', ['quickMessages' => $this->quickMessages()]);
    }

    /**
     * Display tickets list, pre-selecting a specific username
     */
    public function indexByUsername(string $username): View
    {
        User::where('domain', getDomain())->where('username', $username)->firstOrFail();
        return view('admin.messages.index', ['activeUsername' => $username, 'quickMessages' => $this->quickMessages()]);
    }

    public function messageGetUsers(Request $request)
    {
        $tickets = Ticket::with('user:id,username')->where('domain', getDomain())
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')->from('tickets')->where('domain', getDomain())->groupBy('user_id');
            })->orderByDesc(DB::raw('COALESCE(last_reply_at, created_at)'))->get();

        return response()->json($tickets->map(fn ($ticket) => [
            'account_id' => (int) $ticket->user_id,
            'account_user' => $ticket->user?->username ?? '-',
            'chat_unread_admin' => TicketReply::where('ticket_id', $ticket->id)->where('is_admin', false)->whereNull('read_at')->exists() ? 0 : 1,
            'chat_created' => ($ticket->last_reply_at ?? $ticket->created_at)?->toISOString(),
        ])->values());
    }

    public function messageGetAll(Request $request)
    {
        $user = $this->messageUser($request);
        $tickets = Ticket::with(['replies.user:id,username', 'user:id,username'])
            ->where('domain', getDomain())->where('user_id', $user->id)->orderBy('created_at')->get();
        $rows = collect();
        foreach ($tickets as $ticket) {
            $rows->push($this->chatRow($ticket->user_id, $ticket->user?->username, $ticket->user_id, $ticket->user?->username, $ticket->message, $ticket->created_at));
            foreach ($ticket->replies as $reply) {
                $rows->push($this->chatRow($ticket->user_id, $ticket->user?->username, $reply->user_id, $reply->user?->username, $reply->message, $reply->created_at));
            }
        }
        TicketReply::whereIn('ticket_id', $tickets->pluck('id'))->where('is_admin', false)->whereNull('read_at')->update(['read_at' => now()]);
        session()->put('admin_chat_cursor.' . $user->id, (int) ($tickets->flatMap->replies->max('id') ?? 0));
        return response()->json($rows->values());
    }

    public function messageGetNew(Request $request)
    {
        $user = $this->messageUser($request);
        $ticketIds = Ticket::where('domain', getDomain())->where('user_id', $user->id)->pluck('id');
        $cursor = (int) session()->get('admin_chat_cursor.' . $user->id, 0);
        $replies = TicketReply::with('user:id,username')->whereIn('ticket_id', $ticketIds)->where('id', '>', $cursor)->orderBy('id')->get();
        if ($replies->isNotEmpty()) session()->put('admin_chat_cursor.' . $user->id, (int) $replies->max('id'));
        TicketReply::whereIn('id', $replies->where('is_admin', false)->pluck('id'))->update(['read_at' => now()]);
        return response()->json($replies->map(fn ($reply) => $this->chatRow($user->id, $user->username, $reply->user_id, $reply->user?->username, $reply->message, $reply->created_at))->values());
    }

    public function messageSend(Request $request)
    {
        $data = $request->validate(['customer_account_user' => ['required', 'string'], 'message' => ['required', 'string', 'max:5000']]);
        $user = User::where('domain', getDomain())->where('username', $data['customer_account_user'])->firstOrFail();
        $ticket = Ticket::where('domain', getDomain())->where('user_id', $user->id)->latest('last_reply_at')->latest('id')->firstOrFail();
        $reply = TicketReply::create(['ticket_id' => $ticket->id, 'user_id' => Auth::id(), 'message' => $data['message'], 'is_admin' => true, 'read_at' => now()]);
        $ticket->update(['status' => 'answered', 'last_reply_at' => now(), 'assigned_to' => Auth::id()]);
        return response()->json(['success' => true, 'id' => $reply->id]);
    }

    public function ticketHistoryAjax(Request $request)
    {
        $order = DB::table('orders')->where('domain', getDomain())->where('id', (int) $request->input('order_id'))->whereNotNull('ticket')->first();
        if (!$order) return response()->json([]);
        return response()->json([['ticket_request' => $this->ticketType($order->ticket), 'ticket_created' => $order->created_at, 'ticket_updated' => $order->updated_at]]);
    }

    public function ticketProcessing(Request $request) { return $this->changeOrderTicketStatus($request, 'processing'); }
    public function ticketDone(Request $request) { return $this->changeOrderTicketStatus($request, 'completed'); }

    public function ticketExport(Request $request)
    {
        $query = $this->ticketOrderSelection($request);
        return response()->json(['success' => $query->orderBy('id')->pluck('id')->implode("\n")]);
    }

    private function changeOrderTicketStatus(Request $request, string $status)
    {
        $this->ticketOrderSelection($request)->update(['ticket_status' => $status, 'updated_at' => now()]);
        return response()->json(['success' => true]);
    }

    private function ticketOrderSelection(Request $request)
    {
        $type = (int) $request->input('type'); $id = (int) $request->input('data_id');
        $query = DB::table('orders')
            ->where('domain', getDomain())
            ->whereNotNull('ticket')
            ->where('ticket', '!=', '')
            ->where(function ($query) {
                $query->whereNull('ticket_status')->orWhere('ticket_status', 'processing');
            });
        return match ($type) { 0 => $query->where('provider_id', $id), 1 => $query->where('service_id', $id), default => $query->where('id', $id) };
    }

    private function messageUser(Request $request): User { return User::where('domain', getDomain())->where('username', (string) $request->input('account_user'))->firstOrFail(); }
    private function chatRow(int $accountId, ?string $accountUser, int $senderId, ?string $senderUser, string $message, $created): array { return ['account_id' => $accountId, 'account_user' => $accountUser ?? '-', 'chat_sender' => $senderId, 'chat_sender_user' => $senderUser ?? 'Supporter', 'chat_message' => $message, 'chat_created' => $created?->toISOString()]; }
    private function ticketType(?string $ticket): int { $ticket = strtolower((string) $ticket); return str_contains($ticket, 'cancel') ? 1 : (str_contains($ticket, 'refill') ? 2 : 3); }
    private function quickMessages(): array { return array_values(array_filter((array) (Config::where('domain', getDomain())->first()?->quick_chat_messages ?? []))); }

    /**
     * Show ticket by username (latest ticket of that user)
     */
    public function showByUsername(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $ticket = Ticket::with(['user', 'ticketSubject', 'replies.user'])
            ->where('user_id', $user->id)
            ->where('domain', getDomain())
            ->orderBy('last_reply_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->firstOrFail();

        // Mark user replies as read
        $ticket->replies()
               ->where('is_admin', false)
               ->whereNull('read_at')
               ->update(['read_at' => now()]);

        return response()->json([
            'success' => true,
            'ticket' => [
                'id' => $ticket->id,
                'subject' => $ticket->subject,
                'message' => $ticket->message,
                'status' => $ticket->status,
                'priority' => $ticket->priority,
                'created_at' => $ticket->created_at,
                'custom_fields' => $ticket->custom_fields,
                'ticketSubject' => $ticket->ticketSubject ? [
                    'category' => $ticket->ticketSubject->category,
                    'subcategory' => $ticket->ticketSubject->subcategory,
                ] : null,
                'user' => $ticket->user ? [
                    'id' => $ticket->user->id,
                    'username' => $ticket->user->username,
                ] : null,
                'replies' => $ticket->replies->map(function ($reply) {
                    return [
                        'id' => $reply->id,
                        'message' => $reply->message,
                        'is_admin' => $reply->is_admin,
                        'created_at' => $reply->created_at,
                        'user' => $reply->user ? [
                            'id' => $reply->user->id,
                            'username' => $reply->user->username,
                        ] : null,
                        'attachments' => $reply->attachments ?? [],
                    ];
                }),
            ],
        ]);
    }

    /**
     * Get new messages by username
     */
    public function getNewMessagesByUsername(Request $request, string $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $ticket = Ticket::where('user_id', $user->id)
            ->where('domain', getDomain())
            ->orderBy('last_reply_at', 'desc')
            ->firstOrFail();

        return $this->getNewMessages($request, $ticket);
    }

    /**
     * Reply by username
     */
    public function replyByUsername(Request $request, string $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $ticket = Ticket::where('user_id', $user->id)
            ->where('domain', getDomain())
            ->orderBy('last_reply_at', 'desc')
            ->firstOrFail();

        return $this->reply($request, $ticket);
    }

    /**
     * Display ticket details for admin (AJAX)
     */
    public function show(Ticket $ticket)
    {
        abort_if($ticket->domain !== getDomain(), 403);
        $ticket->load(['user', 'ticketSubject', 'replies.user']);
        
        // Mark admin replies as read
        $ticket->replies()
               ->where('is_admin', false)
               ->whereNull('read_at')
               ->update(['read_at' => now()]);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'ticket' => [
                    'id' => $ticket->id,
                    'subject' => $ticket->subject,
                    'status' => $ticket->status,
                    'priority' => $ticket->priority,
                    'created_at' => $ticket->created_at,
                    'custom_fields' => $ticket->custom_fields,
                    'user' => $ticket->user ? [
                        'id' => $ticket->user->id,
                        'username' => $ticket->user->username,
                        'email' => $ticket->user->email,
                        'avatar' => $ticket->user->avatar ?? null
                    ] : null,
                    'ticketSubject' => $ticket->ticketSubject ? [
                        'category' => $ticket->ticketSubject->category,
                        'subcategory' => $ticket->ticketSubject->subcategory
                    ] : null,
                    'replies' => $ticket->replies->map(function($reply, $index) use ($ticket) {
                        $replyData = [
                            'id' => $reply->id,
                            'message' => $reply->message,
                            'is_admin' => $reply->is_admin,
                            'created_at' => $reply->created_at,
                            'user' => $reply->user ? [
                                'id' => $reply->user->id,
                                'username' => $reply->user->username,
                                'avatar' => $reply->user->avatar ?? null
                            ] : null,
                            'attachments' => $reply->attachments ?? []
                        ];
                        
                        // Add ticket info to first reply
                        if ($index === 0) {
                            $replyData['ticket_info'] = [
                                'subject' => $ticket->subject,
                                'category' => $ticket->ticketSubject ? $ticket->ticketSubject->category : null,
                                'subcategory' => $ticket->ticketSubject ? $ticket->ticketSubject->subcategory : null,
                                'custom_fields' => $ticket->custom_fields
                            ];
                        }
                        
                        return $replyData;
                    })
                ]
            ]);
        }

        return view('admin.messages.show', compact('ticket'));
    }

    /**
     * Get new messages for realtime chat
     */
    public function getNewMessages(Request $request, Ticket $ticket)
    {
        $lastId = $request->get('last_id', 0);
        
        $newMessages = $ticket->replies()
            ->with('user')
            ->where('id', '>', $lastId)
            ->orderBy('created_at', 'asc')
            ->get();

        $formattedMessages = $newMessages->map(function($reply) {
            return [
                'id' => $reply->id,
                'message' => $reply->message,
                'is_admin' => $reply->is_admin,
                'created_at' => $reply->created_at,
                'user' => $reply->user ? [
                    'id' => $reply->user->id,
                    'username' => $reply->user->username,
                    'avatar' => $reply->user->avatar ?? null
                ] : null,
                'attachments' => $reply->attachments ?? []
            ];
        });

        return response()->json([
            'success' => true,
            'new_messages' => $formattedMessages
        ]);
    }

    /**
     * Reply to ticket as admin
     */
    public function reply(Request $request, Ticket $ticket)
    {
        abort_if($ticket->domain !== getDomain(), 403);
        $request->validate([
            'message' => 'required|string|max:5000',
            'attachments.*' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,txt,csv',
        ]);

        try {
            // Handle file uploads
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

            // Create reply and update ticket
            $reply = null;
            DB::transaction(function () use ($ticket, $request, $attachments, &$reply) {
                $reply = TicketReply::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => Auth::id(),
                    'message' => $request->message,
                    'is_admin' => true,
                    'attachments' => $attachments,
                ]);

                $ticket->update([
                    'status' => 'answered',
                    'last_reply_at' => now(),
                    'assigned_to' => Auth::id(),
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully.',
                'reply' => [
                    'id' => $reply->id,
                    'attachments' => $attachments
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending reply: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update ticket status
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        abort_if($ticket->domain !== getDomain(), 403);
        $request->validate([
            'status' => 'required|in:open,answered,closed'
        ]);

        $ticket->update([
            'status' => $request->status,
            'assigned_to' => $request->status !== 'open' ? Auth::id() : $ticket->assigned_to,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket status updated successfully.'
        ]);
    }

    /**
     * Assign ticket to admin
     */
    public function assign(Request $request, Ticket $ticket)
    {
        abort_if($ticket->domain !== getDomain(), 403);
        $request->validate([
            'admin_id' => 'nullable|exists:users,id'
        ]);

        $ticket->update([
            'assigned_to' => $request->admin_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ticket assigned successfully.'
        ]);
    }

    /**
     * Delete ticket reply
     */
    public function deleteReply(TicketReply $reply)
    {
        // Check if user has permission to delete this reply
        if (!Auth::user()->hasRole('admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $reply->delete();

        return response()->json([
            'success' => true,
            'message' => 'Reply deleted successfully.'
        ]);
    }

    /**
     * Delete ticket
     */
    public function destroy(Ticket $ticket)
    {
        abort_if($ticket->domain !== getDomain(), 403);
        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully.'
        ]);
    }
}
