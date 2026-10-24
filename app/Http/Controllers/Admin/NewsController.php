<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('domain', getDomain())
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        return view('admin.news.index', compact('news'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'title'    => 'required|string|max:500',
            'content'  => 'nullable|string',
        ]);

        $item = News::create([
            'category' => $request->category,
            'title'    => $request->title,
            'content'  => $request->content,
            'domain'   => getDomain(),
        ]);

        return response()->json(['success' => true, 'item' => $item]);
    }

    public function show(News $news)
    {
        return response()->json(['success' => true, 'item' => $news]);
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'category' => 'required|string',
            'title'    => 'required|string|max:500',
            'content'  => 'nullable|string',
        ]);

        $news->update($request->only('category', 'title', 'content'));

        return response()->json(['success' => true]);
    }

    public function destroy(News $news)
    {
        abort_if($news->domain !== getDomain(), 404);
        $news->delete();
        return response()->json(['success' => true]);
    }

    public function get(Request $request)
    {
        $news = $this->findNews($request);

        return response()->json([
            'id' => $news->id,
            'category' => $news->category,
            'title' => $news->title,
            'content' => $news->content ?? '',
        ]);
    }

    public function add(Request $request)
    {
        $data = $this->validated($request);
        $data['domain'] = getDomain();
        News::create($data);

        return response()->json(['success' => adminMessage('add')]);
    }

    public function updateFromRequest(Request $request)
    {
        $this->findNews($request)->update($this->validated($request));

        return response()->json(['success' => adminMessage('update')]);
    }

    public function deleteNews(Request $request)
    {
        $this->findNews($request)->delete();

        return response()->json(['success' => adminMessage('delete')]);
    }

    private function findNews(Request $request): News
    {
        return News::where('domain', getDomain())->findOrFail((int) $request->input('id'));
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category' => ['required', 'in:Notification,New service,Change service'],
            'title' => ['required', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
        ]);
    }
}

