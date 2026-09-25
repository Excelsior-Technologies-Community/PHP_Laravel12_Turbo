<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostController extends Controller
{
    /**
     * Display posts with search, filters, sorting and pagination.
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
        | Date From Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->input('date_from')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date To Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->input('date_to')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $sort = $request->input('sort', 'latest');

        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;

            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;

            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'latest':
            default:
                $query->latest();
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Posts Per Page
        |--------------------------------------------------------------------------
        */

        $allowedPerPage = [5, 10, 25, 50];

        $perPage = (int) $request->input('per_page', 5);

        if (! in_array($perPage, $allowedPerPage)) {
            $perPage = 5;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $posts = $query
            ->paginate($perPage)
            ->withQueryString();

        return view('posts.index', compact(
            'posts',
            'perPage',
            'sort'
        ));
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

    /**
     * Bulk actions.
     *
     * Actions:
     * - delete
     * - publish
     * - draft
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'post_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'post_ids.*' => [
                'integer',
                'exists:posts,id',
            ],

            'action' => [
                'required',
                'in:delete,publish,draft',
            ],
        ]);

        $ids = $validated['post_ids'];
        $action = $validated['action'];

        if ($action === 'delete') {
            Post::whereIn('id', $ids)->delete();

            $message = count($ids) . ' post(s) deleted successfully.';
        }

        elseif ($action === 'publish') {
            Post::whereIn('id', $ids)
                ->update([
                    'status' => 'published',
                ]);

            $message = count($ids) . ' post(s) published successfully.';
        }

        else {
            Post::whereIn('id', $ids)
                ->update([
                    'status' => 'draft',
                ]);

            $message = count($ids) . ' post(s) moved to draft successfully.';
        }

        return redirect()
            ->route('posts.index')
            ->with('success', $message);
    }

    /**
     * Export filtered posts as CSV.
     */
    public function export(Request $request): StreamedResponse
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
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->input('status')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date From
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->input('date_from')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date To
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->input('date_to')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $sort = $request->input('sort', 'latest');

        if ($sort === 'oldest') {
            $query->oldest();
        }

        elseif ($sort === 'title_asc') {
            $query->orderBy('title', 'asc');
        }

        elseif ($sort === 'title_desc') {
            $query->orderBy('title', 'desc');
        }

        else {
            $query->latest();
        }

        $posts = $query->get();

        return response()->streamDownload(
            function () use ($posts) {

                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'ID',
                    'Title',
                    'Description',
                    'Status',
                    'Created At',
                    'Updated At',
                ]);

                foreach ($posts as $post) {
                    fputcsv($handle, [
                        $post->id,
                        $post->title,
                        $post->description,
                        ucfirst($post->status),
                        $post->created_at?->format('Y-m-d H:i:s'),
                        $post->updated_at?->format('Y-m-d H:i:s'),
                    ]);
                }

                fclose($handle);
            },
            'posts-' . now()->format('Y-m-d-H-i-s') . '.csv',
            [
                'Content-Type' => 'text/csv',
            ]
        );
    }
}