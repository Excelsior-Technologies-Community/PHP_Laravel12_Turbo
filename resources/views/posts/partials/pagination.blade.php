<div class="pagination-wrapper">

    <div class="pagination">

        @for(
            $page = 1;
            $page <= $posts->lastPage();
            $page++
        )

            @if($page == $posts->currentPage())

                <span class="active">
                    {{ $page }}
                </span>

            @else

                <a
                    href="{{ $posts->url($page) }}"
                    data-turbo-frame="post-search-results"
                >
                    {{ $page }}
                </a>

            @endif

        @endfor

    </div>

</div>