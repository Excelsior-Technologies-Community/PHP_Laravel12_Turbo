@foreach($attachments as $attachment)

    <turbo-stream action="prepend" target="attachments-grid-{{ $post->id }}">

        <template>

            @include('attachments.partials.item', ['attachment' => $attachment])

        </template>

    </turbo-stream>

@endforeach


<turbo-stream action="remove" target="empty-attachments-{{ $post->id }}">

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

        @include('partials.toast', ['message' => $message, 'type' => 'success'])

    </template>

</turbo-stream>
