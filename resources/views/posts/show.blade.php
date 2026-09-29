@extends('layouts.app')

@section('content')

<div class="top-bar">

    <div>

        <h2>{{ $post->title }}</h2>

        <span class="status-badge status-{{ $post->status }}">

            {{ ucfirst($post->status) }}

        </span>

    </div>


    <div>

        <a
            href="{{ route('posts.index') }}"
            class="btn btn-secondary">

            ← Back

        </a>


        <a
            href="{{ route('posts.edit', $post) }}"
            class="btn btn-warning">

            ✏️ Edit

        </a>

    </div>

</div>

<hr>

<div class="card">

    <div class="post-detail-content">

        <p class="post-description-full">

            {{ $post->description ?: 'No description provided.' }}

        </p>


        <div class="post-meta-details text-muted mt-3">

            <small>

                📅 Created: {{ $post->created_at ? $post->created_at->format('M d, Y h:i A') : 'N/A' }} |

                🔄 Last Updated: {{ $post->updated_at ? $post->updated_at->format('M d, Y h:i A') : 'N/A' }}

            </small>

        </div>

    </div>

</div>


{{-- Attachments Section --}}

<div class="card mt-4">

    <h3>📁 Post Attachments & Gallery</h3>


    {{-- Instant Drag-and-Drop Uploader --}}

    @include('attachments.partials.dropzone', ['post' => $post, 'standalone' => true])


    <hr>


    {{-- Attachments Gallery List --}}

    @include('attachments.partials.list', ['post' => $post])

</div>


{{-- Post Activity History --}}

<div class="card mt-4">

    <h3>📜 Post History & Audit Trail</h3>


    <div class="activity-list mt-2">

        @forelse($post->activities as $activity)

            @include('activities.partials.item', ['activity' => $activity])

        @empty

            <div class="empty-activities">

                No activities recorded for this post yet.

            </div>

        @endforelse

    </div>

</div>

@endsection