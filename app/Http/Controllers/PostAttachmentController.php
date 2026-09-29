<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Post;
use App\Models\PostAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostAttachmentController extends Controller
{
    /**
     * Upload multi-file attachments to a post with Turbo Stream response.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'files' => 'required|array|min:1',
            'files.*' => 'required|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,txt,zip|max:10240',
        ]);

        $uploadedAttachments = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store('attachments/' . $post->id, 'public');
            $mime = $file->getClientMimeType();
            $fileType = str_contains($mime, 'image') ? 'image' : 'document';

            $attachment = $post->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $fileType,
                'file_size' => $file->getSize(),
            ]);

            $uploadedAttachments[] = $attachment;
        }

        // Create Activity Log
        $count = count($uploadedAttachments);
        $activity = ActivityLog::create([
            'post_id' => $post->id,
            'action' => 'upload',
            'description' => "Uploaded {$count} attachment(s) to post '{$post->title}'",
        ]);

        if ($request->wantsTurboStream()) {
            return response()
                ->view('attachments.streams.store', [
                    'post' => $post,
                    'attachments' => $uploadedAttachments,
                    'activity' => $activity,
                    'message' => "{$count} attachment(s) uploaded successfully!",
                ])
                ->header('Content-Type', 'text/vnd.turbo-stream.html');
        }

        return back()->with('success', "{$count} attachment(s) uploaded successfully!");
    }

    /**
     * Delete attachment with Turbo Stream response.
     */
    public function destroy(Request $request, PostAttachment $attachment)
    {
        $attachmentId = $attachment->id;
        $fileName = $attachment->file_name;
        $post = $attachment->post;

        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $attachment->delete();

        // Log Activity
        $activity = ActivityLog::create([
            'post_id' => $post?->id,
            'action' => 'delete_attachment',
            'description' => "Deleted attachment '{$fileName}'",
        ]);

        if ($request->wantsTurboStream()) {
            return response()
                ->view('attachments.streams.destroy', [
                    'attachmentId' => $attachmentId,
                    'activity' => $activity,
                    'message' => "Attachment '{$fileName}' deleted!",
                ])
                ->header('Content-Type', 'text/vnd.turbo-stream.html');
        }

        return back()->with('success', "Attachment deleted successfully.");
    }
}
