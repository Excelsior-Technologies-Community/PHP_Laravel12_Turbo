<turbo-stream action="prepend" target="post-search-results">

    <template>

        @include('posts.partials.row')

    </template>

</turbo-stream>

<turbo-stream action="replace" target="turbo-notification">

    <template>

        <div
            id="turbo-notification"
            class="alert alert-success">

            Post created successfully!

        </div>

    </template>

</turbo-stream>