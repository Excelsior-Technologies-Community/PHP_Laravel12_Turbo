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

        <a
            href="{{ route('dashboard') }}"
            class="btn btn-secondary"
        >
            Dashboard
        </a>

        <a
            href="{{ route('posts.create') }}"
            class="btn btn-primary"
        >
            + Create Post
        </a>

    </div>

</div>

<hr>


<turbo-frame id="post-search-results">

    {{-- =========================================================
         FILTER PANEL
    ========================================================== --}}

    <div class="search-panel">

        <form
            method="GET"
            action="{{ route('posts.index') }}"
            data-turbo-frame="post-search-results"
        >

            <div class="filter-grid">

                {{-- Search --}}

                <div>

                    <label>
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search title or description..."
                    >

                </div>


                {{-- Status --}}

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
                            @selected(request('status') === 'published')
                        >
                            Published
                        </option>

                        <option
                            value="draft"
                            @selected(request('status') === 'draft')
                        >
                            Draft
                        </option>

                    </select>

                </div>


                {{-- Date From --}}

                <div>

                    <label>
                        Date From
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        value="{{ request('date_from') }}"
                    >

                </div>


                {{-- Date To --}}

                <div>

                    <label>
                        Date To
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        value="{{ request('date_to') }}"
                    >

                </div>


                {{-- Sort --}}

                <div>

                    <label>
                        Sort
                    </label>

                    <select name="sort">

                        <option
                            value="latest"
                            @selected(request('sort', 'latest') === 'latest')
                        >
                            Newest First
                        </option>

                        <option
                            value="oldest"
                            @selected(request('sort') === 'oldest')
                        >
                            Oldest First
                        </option>

                        <option
                            value="title_asc"
                            @selected(request('sort') === 'title_asc')
                        >
                            Title A-Z
                        </option>

                        <option
                            value="title_desc"
                            @selected(request('sort') === 'title_desc')
                        >
                            Title Z-A
                        </option>

                    </select>

                </div>


                {{-- Per Page --}}

                <div>

                    <label>
                        Per Page
                    </label>

                    <select name="per_page">

                        @foreach([5, 10, 25, 50] as $number)

                            <option
                                value="{{ $number }}"
                                @selected($perPage == $number)
                            >
                                {{ $number }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Search Button --}}

                <div>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        🔎 Apply Filters
                    </button>

                </div>


                {{-- Clear --}}

                <div>

                    <a
                        href="{{ route('posts.index') }}"
                        class="btn btn-secondary"
                    >
                        🧹 Clear
                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- =========================================================
         EXPORT
    ========================================================== --}}

    <div class="action-bar">

        <div>

            <strong>
                {{ $posts->total() }}
            </strong>

            result(s)

        </div>

        <div>

            <a
                href="{{ route('posts.export', request()->query()) }}"
                class="btn btn-success"
                data-turbo="false"
            >
                📥 Export CSV
            </a>

        </div>

    </div>


    {{-- =========================================================
         BULK ACTION FORM
    ========================================================== --}}

    <form
        method="POST"
        action="{{ route('posts.bulkAction') }}"
        data-turbo="false"
        onsubmit="return confirmBulkAction();"
    >

        @csrf

        <div class="bulk-toolbar">

            <div>

                <label class="select-all-label">

                    <input
                        type="checkbox"
                        id="select-all"
                    >

                    Select All

                </label>

                <span id="selected-count">
                    0 selected
                </span>

            </div>


            <div class="bulk-controls">

                <select
                    name="action"
                    id="bulk-action"
                    required
                >

                    <option value="">
                        Bulk Action
                    </option>

                    <option value="publish">
                        🟢 Publish Selected
                    </option>

                    <option value="draft">
                        📝 Move to Draft
                    </option>

                    <option value="delete">
                        🗑️ Delete Selected
                    </option>

                </select>


                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Apply
                </button>

            </div>

        </div>


        {{-- =====================================================
             POSTS
        ====================================================== --}}

        @if($posts->count())

            @foreach($posts as $post)

                @include('posts.partials.row')

            @endforeach

        @else

            <div class="empty-state">

                No posts found for the selected filters.

            </div>

        @endif

    </form>


    {{-- =========================================================
         PAGINATION
    ========================================================== --}}

    @if($posts->hasPages())

        @include('posts.partials.pagination')

    @endif

</turbo-frame>


<script>

document.addEventListener('DOMContentLoaded', function () {

    setupBulkSelection();

});

document.addEventListener('turbo:load', function () {

    setupBulkSelection();

});


function setupBulkSelection()
{
    const selectAll = document.getElementById('select-all');

    const checkboxes = document.querySelectorAll(
        '.post-checkbox'
    );

    const selectedCount = document.getElementById(
        'selected-count'
    );

    if (!selectAll) {
        return;
    }

    function updateCount()
    {
        const checked = document.querySelectorAll(
            '.post-checkbox:checked'
        ).length;

        if (selectedCount) {

            selectedCount.textContent =
                checked + ' selected';

        }
    }

    selectAll.addEventListener('change', function () {

        checkboxes.forEach(function (checkbox) {

            checkbox.checked =
                selectAll.checked;

        });

        updateCount();

    });

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            updateCount();

        });

    });

    updateCount();
}


function confirmBulkAction()
{
    const selected = document.querySelectorAll(
        '.post-checkbox:checked'
    ).length;

    const action = document.getElementById(
        'bulk-action'
    ).value;

    if (selected === 0) {

        alert(
            'Please select at least one post.'
        );

        return false;
    }

    if (!action) {

        alert(
            'Please select a bulk action.'
        );

        return false;
    }

    if (action === 'delete') {

        return confirm(
            'Are you sure you want to delete ' +
            selected +
            ' selected post(s)?'
        );

    }

    return confirm(
        'Apply this action to ' +
        selected +
        ' selected post(s)?'
    );
}

</script>

@endsection