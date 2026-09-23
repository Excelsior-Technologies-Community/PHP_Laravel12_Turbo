@extends('layouts.app')

@section('content')

<div class="dashboard-header">

    <div>
        <h2>Post Statistics Dashboard</h2>

        <p class="dashboard-subtitle">
            Monitor post activity and content status
        </p>
    </div>

    <a href="{{ route('posts.index') }}" class="btn btn-primary">
        Manage Posts
    </a>

</div>

<hr>

<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon">📊</div>

        <div>
            <div class="stat-label">
                Total Posts
            </div>

            <div class="stat-number">
                {{ $totalPosts }}
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">🟢</div>

        <div>
            <div class="stat-label">
                Published
            </div>

            <div class="stat-number">
                {{ $publishedPosts }}
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📝</div>

        <div>
            <div class="stat-label">
                Drafts
            </div>

            <div class="stat-number">
                {{ $draftPosts }}
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">📅</div>

        <div>
            <div class="stat-label">
                Created Today
            </div>

            <div class="stat-number">
                {{ $todayPosts }}
            </div>
        </div>
    </div>

</div>

<hr>

<div class="dashboard-section">

    <div class="section-header">

        <h2>Latest Post</h2>

        <a href="{{ route('posts.create') }}"
           class="btn btn-primary">
            + Create Post
        </a>

    </div>

    @if($latestPost)

        <div class="latest-post">

            <div>

                <h3>
                    {{ $latestPost->title }}
                </h3>

                <p>
                    {{ $latestPost->description ?: 'No description provided.' }}
                </p>

                <small>
                    Created
                    {{ $latestPost->created_at->format('d M Y, h:i A') }}
                </small>

            </div>

            <span class="status-badge status-{{ $latestPost->status }}">
                {{ ucfirst($latestPost->status) }}
            </span>

        </div>

    @else

        <div class="empty-state">
            No posts have been created yet.
        </div>

    @endif

</div>

<hr>

<div class="dashboard-section">

    <h2>Recent Activity</h2>

    @forelse($recentPosts as $post)

        <div class="activity-item">

            <div>

                <strong>
                    {{ $post->title }}
                </strong>

                <div class="activity-time">
                    {{ $post->created_at->diffForHumans() }}
                </div>

            </div>

            <span class="status-badge status-{{ $post->status }}">
                {{ ucfirst($post->status) }}
            </span>

        </div>

    @empty

        <div class="empty-state">
            No recent activity.
        </div>

    @endforelse

</div>

@endsection