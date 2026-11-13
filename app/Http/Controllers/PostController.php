<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true)
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('q') . '%');
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category', $request->input('category'));
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->where('name', $request->input('tag'));
                });
            })
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(10) // 10 per page (5 top, 5 bottom)
            ->withQueryString();

        $categories = Post::query()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = [
            'Announcement',
            'Health',
            'Peace & Order',
            'Ayuda',
            'Community Updates',
        ];

        $tags = Tag::orderBy('name')->get();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $isPublished = $request->boolean('is_published');

        $postData = collect($validated)->except('tags')->toArray();
        $postData['is_published'] = $isPublished;
        $postData['published_at'] = $isPublished ? now() : null;

        $post = $request->user()->author->posts()->create($postData);

        if (! empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('posts.show', $post->id)->with('status', 'Post created successfully.');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        if (! $post->is_published) {
            abort(404);
        }

        $post->increment('views');

        $post->load([
            'author',
            'tags',
            'comments' => function ($query) {
                $query->with('user')->latest();
            },
        ]);

        return view('posts.show', compact('post'));
    }
}
