@extends('layouts.app')

@section('content')

<div class="top-bar">

    <div>
        <h2>All Posts</h2>

        <div class="result-count">
            {{ $posts->total() }} post(s) found
        </div>
    </div>

    <div>

        <a href="{{ route('dashboard') }}"
           class="btn btn-secondary">

            Dashboard

        </a>

        <a href="{{ route('posts.create') }}"
           class="btn btn-primary">

            + Create Post

        </a>

    </div>

</div>

<hr>

<turbo-frame id="post-search-results">

    <div class="search-panel">

<form method="GET"
      action="{{ route('posts.index') }}"
      data-turbo-frame="post-search-results">

            <div class="filter-grid">

                <div>

                    <label>
                        Search Posts
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search title or description..."
                    >

                </div>

                <div>

                    <label>
                        Status
                    </label>

                    <select name="status">

                        <option value="">
                            All Statuses
                        </option>

                        <option
                            value="published"
                            @selected(request('status') === 'published')>
                            Published
                        </option>

                        <option
                            value="draft"
                            @selected(request('status') === 'draft')>
                            Draft
                        </option>

                    </select>

                </div>

                <div>

                    <label>
                        Date
                    </label>

                    <input
                        type="date"
                        name="date"
                        value="{{ request('date') }}"
                    >

                </div>

                <div>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        🔎 Search

                    </button>

                </div>

            </div>

        </form>

    </div>

    @if($posts->count())

        @foreach($posts as $post)

            @include('posts.partials.row')

        @endforeach

    @else

        <div class="empty-state">

            No posts found for the selected filters.

        </div>

    @endif

    @if($posts->hasPages())

        @include('posts.partials.pagination')

    @endif

</turbo-frame>

@endsection