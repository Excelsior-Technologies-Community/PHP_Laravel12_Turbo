<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
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
        $query = Post::with('attachments');

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
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        /*
        |--------------------------------------------------------------------------
        | Date To Filter
        |--------------------------------------------------------------------------
        */
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
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
        $posts = $query->paginate($perPage)->withQueryString();

        $recentActivities = ActivityLog::with('post')->latest()->take(20)->get();

        return view('posts.index', compact('posts', 'perPage', 'sort', 'recentActivities'));
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,zip|max:10240',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        // Process attachments if uploaded
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('attachments/' . $post->id, 'public');
                $mime = $file->getClientMimeType();
                $fileType = str_contains($mime, 'image') ? 'image' : 'document';

                $post->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $fileType,
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Log Activity
        ActivityLog::create([
            'post_id' => $post->id,
            'action' => 'create',
            'description' => "Created new post '{$post->title}'",
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', "Post '{$post->title}' created successfully!");
    }

    /**
     * Display individual post.
     */
    public function show(Post $post)
    {
        $post->load(['attachments', 'activities' => function ($q) {
            $q->latest()->take(10);
        }]);

        return view('posts.show', compact('post'));
    }

    /**
     * Show edit form.
     */
    public function edit(Post $post)
    {
        $post->load('attachments');
        return view('posts.edit', compact('post'));
    }

    /**
     * Update post.
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:published,draft',
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,zip|max:10240',
        ]);

        $post->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
        ]);

        // Handle file uploads during edit
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('attachments/' . $post->id, 'public');
                $mime = $file->getClientMimeType();
                $fileType = str_contains($mime, 'image') ? 'image' : 'document';

                $post->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $fileType,
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        // Log Activity
        ActivityLog::create([
            'post_id' => $post->id,
            'action' => 'update',
            'description' => "Updated post '{$post->title}'",
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', "Post '{$post->title}' updated successfully!");
    }

    /**
     * Instant Quick Status Switcher (Draft ↔ Published) via Turbo Stream.
     */
    public function toggleStatus(Request $request, Post $post)
    {
        $newStatus = $post->status === 'published' ? 'draft' : 'published';
        $post->update(['status' => $newStatus]);

        // Log Activity
        $activity = ActivityLog::create([
            'post_id' => $post->id,
            'action' => 'status_toggle',
            'description' => "Changed status of '{$post->title}' to " . ucfirst($newStatus),
        ]);

        if ($request->wantsTurboStream()) {
            return response()
                ->view('posts.streams.update', [
                    'post' => $post->fresh()->load('attachments'),
                    'activity' => $activity,
                    'toastMessage' => "Status changed to " . ucfirst($newStatus) . "!",
                ])
                ->header('Content-Type', 'text/vnd.turbo-stream.html');
        }

        return back()->with('success', "Status updated to " . ucfirst($newStatus) . ".");
    }

    /**
     * Delete post via Turbo Stream or Redirect.
     */
    public function destroy(Request $request, Post $post)
    {
        $postId = $post->id;
        $title = $post->title;

        $post->delete();

        // Log Activity
        $activity = ActivityLog::create([
            'post_id' => null,
            'action' => 'delete',
            'description' => "Deleted post '{$title}' (ID: #{$postId})",
        ]);

        if ($request->wantsTurboStream()) {
            return response()
                ->view('posts.streams.destroy', [
                    'postId' => $postId,
                    'activity' => $activity,
                    'toastMessage' => "Post '{$title}' deleted successfully!",
                ])
                ->header('Content-Type', 'text/vnd.turbo-stream.html');
        }

        return redirect()
            ->route('posts.index')
            ->with('success', "Post '{$title}' deleted successfully!");
    }

    /**
     * Bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'post_ids' => 'required|array|min:1',
            'post_ids.*' => 'integer|exists:posts,id',
            'action' => 'required|in:delete,publish,draft',
        ]);

        $ids = $validated['post_ids'];
        $action = $validated['action'];

        if ($action === 'delete') {
            Post::whereIn('id', $ids)->delete();
            $message = count($ids) . ' post(s) deleted successfully.';
            $actionLabel = 'deleted';
        } elseif ($action === 'publish') {
            Post::whereIn('id', $ids)->update(['status' => 'published']);
            $message = count($ids) . ' post(s) published successfully.';
            $actionLabel = 'published';
        } else {
            Post::whereIn('id', $ids)->update(['status' => 'draft']);
            $message = count($ids) . ' post(s) moved to draft.';
            $actionLabel = 'moved to draft';
        }

        // Log Activity
        ActivityLog::create([
            'post_id' => null,
            'action' => 'bulk_action',
            'description' => "Bulk {$actionLabel} on " . count($ids) . " post(s)",
        ]);

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

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $sort = $request->input('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest();
        } elseif ($sort === 'title_asc') {
            $query->orderBy('title', 'asc');
        } elseif ($sort === 'title_desc') {
            $query->orderBy('title', 'desc');
        } else {
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
            ['Content-Type' => 'text/csv']
        );
    }
}