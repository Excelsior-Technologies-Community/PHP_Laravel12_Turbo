<div id="attachments-grid-{{ $post->id }}" class="attachments-grid">

    @forelse($post->attachments as $attachment)

        @include('attachments.partials.item', ['attachment' => $attachment])

    @empty

        <div class="empty-attachments-notice" id="empty-attachments-{{ $post->id }}">

            No attachments uploaded yet.

        </div>

    @endforelse

</div>
