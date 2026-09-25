<turbo-stream
    action="replace"
    target="post-{{ $post->id }}"
>

    <template>

        @include('posts.partials.row')

    </template>

</turbo-stream>


<turbo-stream
    action="replace"
    target="turbo-notification"
>

    <template>

        <div
            id="turbo-notification"
            class="alert alert-success"
        >

            Post updated successfully!

        </div>

    </template>

</turbo-stream>