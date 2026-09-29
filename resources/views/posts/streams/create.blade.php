<turbo-stream action="prepend" target="posts-list">

    <template>

        @include('posts.partials.row', ['post' => $post])

    </template>

</turbo-stream>


<turbo-stream action="prepend" target="activity-feed-list">

    <template>

        @include('activities.partials.item', ['activity' => $activity])

    </template>

</turbo-stream>


<turbo-stream action="remove" target="empty-activities-notice">

</turbo-stream>


<turbo-stream action="prepend" target="toast-container">

    <template>

        @include('partials.toast', ['message' => $toastMessage, 'type' => 'success'])

    </template>

</turbo-stream>