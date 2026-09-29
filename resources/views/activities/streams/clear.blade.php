<turbo-stream action="replace" target="activity-feed-list">

    <template>

        <div id="activity-feed-list" class="activity-list">

            <div class="empty-activities" id="empty-activities-notice">

                Activity logs cleared.

            </div>

        </div>

    </template>

</turbo-stream>


<turbo-stream action="prepend" target="toast-container">

    <template>

        @include('partials.toast', ['message' => 'Activity feed cleared!', 'type' => 'info'])

    </template>

</turbo-stream>
