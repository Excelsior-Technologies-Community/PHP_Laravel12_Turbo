<turbo-stream
    action="remove"
    target="post-{{ $postId }}">

</turbo-stream>

<turbo-stream
    action="replace"
    target="turbo-notification">

    <template>

        <div
            id="turbo-notification"
            class="alert alert-success">

            Post deleted successfully!

        </div>

    </template>

</turbo-stream>