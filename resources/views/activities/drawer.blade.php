<div id="activity-drawer" class="activity-drawer">

    <div class="drawer-header">

        <div class="drawer-title">

            📊 <strong>Live Activity Studio</strong>

        </div>


        <div class="drawer-actions">

            <form method="POST" action="{{ route('activities.clear') }}" data-turbo="true" style="display:inline;">

                @csrf

                @method('DELETE')

                <button type="submit" class="btn-clear-activity" title="Clear All Activity Logs">

                    🧹 Clear

                </button>

            </form>


            <button type="button" class="drawer-close-btn" onclick="toggleActivityDrawer()">

                ✕

            </button>

        </div>

    </div>


    <div class="drawer-body">

        <div id="activity-feed-list" class="activity-list">

            @forelse($recentActivities ?? \App\Models\ActivityLog::latest()->take(20)->get() as $activity)

                @include('activities.partials.item', ['activity' => $activity])

            @empty

                <div class="empty-activities" id="empty-activities-notice">

                    No activity logged yet. Perform actions to see live updates!

                </div>

            @endforelse

        </div>

    </div>

</div>


<div id="drawer-backdrop" class="drawer-backdrop" onclick="toggleActivityDrawer()"></div>
