<div class="pagination-wrapper">

    <div class="pagination">

        {{-- Previous Page --}}
        @if($posts->onFirstPage())

            <span>
                Previous
            </span>

        @else

            <a
                href="{{ $posts->previousPageUrl() }}"
                data-turbo-frame="post-search-results">

                Previous

            </a>

        @endif


        {{-- Page Numbers --}}
        @foreach($posts->getUrlRange(
            max(1, $posts->currentPage() - 2),
            min($posts->lastPage(), $posts->currentPage() + 2)
        ) as $page => $url)

            @if($page == $posts->currentPage())

                <span class="active">
                    {{ $page }}
                </span>

            @else

                <a
                    href="{{ $url }}"
                    data-turbo-frame="post-search-results">

                    {{ $page }}

                </a>

            @endif

        @endforeach


        {{-- Next Page --}}
        @if($posts->hasMorePages())

            <a
                href="{{ $posts->nextPageUrl() }}"
                data-turbo-frame="post-search-results">

                Next

            </a>

        @else

            <span>
                Next
            </span>

        @endif

    </div>

</div>