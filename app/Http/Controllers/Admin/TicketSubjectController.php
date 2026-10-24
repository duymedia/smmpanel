<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TicketSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketSubjectController extends Controller
{
    public function index()
    {
        $subjects = TicketSubject::orderBy('sort_order')->orderBy('category')->get();
        $categories = TicketSubject::select('category')->distinct()->orderBy('category')->pluck('category');
        
        return view('admin.ticket-subjects.index', compact('subjects', 'categories'));
    }

    public function create()
    {
        $categories = TicketSubject::select('category')->distinct()->orderBy('category')->pluck('category');
        return view('admin.ticket-subjects.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'show_message_only' => 'boolean',
            'status' => 'required|in:0,1',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $requiredFields = null;
        if ($request->filled('required_fields_json')) {
            $requiredFields = json_decode($request->required_fields_json, true);
        }

        $subject = TicketSubject::create([
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'show_message_only' => $request->boolean('show_message_only'),
            'required_fields' => $requiredFields,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Thêm thành công.', 'subject' => $subject]);
        }

        return redirect()->route('admin.ticket-subjects.index')->with('success', 'Thêm ticket subject thành công.');
    }

    public function show(TicketSubject $ticketSubject)
    {
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json(['success' => true, 'subject' => $ticketSubject]);
        }

        return redirect()->route('admin.ticket-subjects.edit', $ticketSubject);
    }

    public function edit(TicketSubject $ticketSubject)
    {
        $categories = TicketSubject::select('category')->distinct()->orderBy('category')->pluck('category');
        return view('admin.ticket-subjects.form', compact('ticketSubject', 'categories'));
    }

    public function update(Request $request, TicketSubject $ticketSubject)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'subcategory' => 'nullable|string|max:255',
            'show_message_only' => 'boolean',
            'status' => 'required|in:0,1',
            'sort_order' => 'integer|min:0'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $requiredFields = null;
        if ($request->filled('required_fields_json')) {
            $requiredFields = json_decode($request->required_fields_json, true);
        }

        $ticketSubject->update([
            'category' => $request->category,
            'subcategory' => $request->subcategory,
            'show_message_only' => $request->boolean('show_message_only'),
            'required_fields' => $requiredFields,
            'status' => $request->status,
            'sort_order' => $request->sort_order ?? 0
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công.']);
        }

        return redirect()->route('admin.ticket-subjects.index')->with('success', 'Cập nhật ticket subject thành công.');
    }

    public function destroy(TicketSubject $ticketSubject)
    {
        if ($ticketSubject->tickets()->count() > 0) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Không thể xóa vì có ticket đang sử dụng.']);
            }
            return redirect()->back()->with('error', 'Không thể xóa vì có ticket đang sử dụng subject này.');
        }

        $ticketSubject->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Xóa thành công.']);
        }

        return redirect()->route('admin.ticket-subjects.index')->with('success', 'Xóa ticket subject thành công.');
    }

    public function toggleStatus(TicketSubject $ticketSubject)
    {
        $ticketSubject->update(['status' => $ticketSubject->status == 1 ? 0 : 1]);

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
    }

    // Reorder subjects via drag & drop
    public function reorder(Request $request)
    {
        $items = $request->input('items', []);
        foreach ($items as $item) {
            TicketSubject::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }
        return response()->json(['success' => true]);
    }

    // API endpoint để lấy subcategories theo category
    public function getSubcategories(Request $request)
    {
        $category = $request->get('category');
        
        $subcategories = TicketSubject::where('category', $category)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get(['id', 'subcategory', 'show_message_only', 'required_fields']);

        return response()->json($subcategories);
    }

    public function getFromRequest(Request $request)
    {
        return response()->json($this->findFromRequest($request));
    }

    public function saveFromRequest(Request $request)
    {
        $data = $request->validate([
            'id' => ['nullable', 'integer'],
            'category' => ['required', 'string', 'max:255'],
            'subcategory' => ['nullable', 'string', 'max:255'],
            'show_message_only' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'required_fields_json' => ['nullable', 'json'],
        ]);

        $fields = empty($data['required_fields_json']) ? [] : json_decode($data['required_fields_json'], true);
        if (!is_array($fields) || !array_is_list($fields)) {
            return response()->json(['error' => 'Trường bắt buộc phải là một mảng JSON hợp lệ.']);
        }

        $values = [
            'category' => $data['category'],
            'subcategory' => $data['subcategory'] ?? null,
            'show_message_only' => (bool) $data['show_message_only'],
            'required_fields' => $fields,
            'status' => (int) $data['status'],
            'sort_order' => (int) $data['sort_order'],
        ];

        $subject = empty($data['id']) ? new TicketSubject() : $this->findFromRequest($request);
        $subject->fill($values)->save();

        return response()->json(['success' => empty($data['id']) ? 'Thêm chủ đề thành công.' : 'Cập nhật chủ đề thành công.']);
    }

    public function toggleFromRequest(Request $request)
    {
        $subject = $this->findFromRequest($request);
        $subject->update(['status' => $request->boolean('status')]);

        return response()->json(['success' => true]);
    }

    public function deleteFromRequest(Request $request)
    {
        $subject = $this->findFromRequest($request);
        if ($subject->tickets()->exists()) {
            return response()->json(['error' => 'Không thể xóa vì đang có phiếu sử dụng chủ đề này.']);
        }
        $subject->delete();

        return response()->json(['success' => true]);
    }

    public function reorderFromRequest(Request $request)
    {
        foreach ($request->validate(['items' => ['required', 'array'], 'items.*.id' => ['required', 'integer'], 'items.*.sort_order' => ['required', 'integer', 'min:0']])['items'] as $item) {
            TicketSubject::whereKey($item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    private function findFromRequest(Request $request): TicketSubject
    {
        return TicketSubject::findOrFail((int) $request->input('id'));
    }
}
