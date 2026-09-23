<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display posts with search, filtering and pagination.
     */
    public function index(Request $request)
    {
        $query = Post::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        /*
        |--------------------------------------------------------------------------
        | Paginated Results
        |--------------------------------------------------------------------------
        */

        $posts = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show create post form.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store new post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:published,draft',
            ],
        ]);

        Post::create($validated);

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Post created successfully!'
            );
    }

    /**
     * Display individual post.
     */
    public function show(Post $post)
    {
        return view(
            'posts.show',
            compact('post')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(Post $post)
    {
        return view(
            'posts.edit',
            compact('post')
        );
    }

    /**
     * Update post.
     */
    public function update(
        Request $request,
        Post $post
    ) {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'in:published,draft',
            ],
        ]);

        $post->update($validated);

        /*
        |--------------------------------------------------------------------------
        | Turbo Stream Response
        |--------------------------------------------------------------------------
        */

        if ($request->wantsTurboStream()) {
            return response()
                ->view(
                    'posts.streams.update',
                    compact('post')
                )
                ->header(
                    'Content-Type',
                    'text/vnd.turbo-stream.html'
                );
        }

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Post updated successfully!'
            );
    }

    /**
     * Delete post.
     */
    public function destroy(
        Request $request,
        Post $post
    ) {
        $postId = $post->id;

        $post->delete();

        /*
        |--------------------------------------------------------------------------
        | Turbo Stream Response
        |--------------------------------------------------------------------------
        */

        if ($request->wantsTurboStream()) {
            return response()
                ->view(
                    'posts.streams.destroy',
                    compact('postId')
                )
                ->header(
                    'Content-Type',
                    'text/vnd.turbo-stream.html'
                );
        }

        return redirect()
            ->route('posts.index')
            ->with(
                'success',
                'Post deleted successfully!'
            );
    }
}