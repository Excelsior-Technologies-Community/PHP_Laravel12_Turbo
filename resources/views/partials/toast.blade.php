<div class="toast toast-{{ $type ?? 'success' }}" data-toast-item>

    <div class="toast-icon">

        @if(($type ?? 'success') === 'success')

            ✅

        @elseif(($type ?? 'success') === 'error')

            ❌

        @elseif(($type ?? 'success') === 'warning')

            ⚠️

        @else

            ℹ️

        @endif

    </div>


    <div class="toast-message">

        {{ $message }}

    </div>


    <button type="button" class="toast-close" onclick="this.parentElement.remove()">

        &times;

    </button>

</div>
