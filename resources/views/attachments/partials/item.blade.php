<div class="attachment-card" id="attachment-{{ $attachment->id }}">

    <div class="attachment-preview">

        @if($attachment->file_type === 'image')

            <img src="{{ $attachment->url }}" alt="{{ $attachment->file_name }}" class="attachment-img-preview" />

        @else

            <div class="attachment-doc-icon">

                📄

            </div>

        @endif

    </div>


    <div class="attachment-info">

        <div class="attachment-name" title="{{ $attachment->file_name }}">

            {{ Str::limit($attachment->file_name, 18) }}

        </div>


        <div class="attachment-meta">

            {{ $attachment->formatted_size }}

        </div>

    </div>


    <div class="attachment-actions">

        <a href="{{ $attachment->url }}" target="_blank" class="attachment-btn-view" title="View / Download">

            👁️

        </a>


        <form method="POST" action="{{ route('attachments.destroy', $attachment) }}" data-turbo="true" style="display:inline;">

            @csrf

            @method('DELETE')

            <button type="submit" class="attachment-btn-delete" title="Delete attachment" onclick="return confirm('Remove this file?');">

                🗑️

            </button>

        </form>

    </div>

</div>
