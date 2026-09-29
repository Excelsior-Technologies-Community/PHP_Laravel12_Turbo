<div class="activity-item" id="activity-item-{{ $activity->id }}">

    <div class="activity-main">

        <div class="activity-icon activity-{{ $activity->action }}">

            @switch($activity->action)

                @case('create')

                    ✨

                    @break

                @case('update')

                    ✏️

                    @break

                @case('delete')

                    🗑️

                    @break

                @case('status_toggle')

                    🔁

                    @break

                @case('upload')

                    📁

                    @break

                @case('delete_attachment')

                    ❌

                    @break

                @default

                    ⚡

            @endswitch

        </div>


        <div class="activity-details">

            <div class="activity-desc">

                {{ $activity->description }}

            </div>


            <div class="activity-time">

                {{ $activity->created_at ? $activity->created_at->diffForHumans() : 'Just now' }}

            </div>

        </div>

    </div>

</div>
