<div class="dropzone-container" id="dropzone-{{ $post->id ?? 'new' }}">

    @if(isset($standalone) && $standalone)

        <form method="POST" action="{{ isset($post) ? route('posts.attachments.store', $post) : '#' }}" enctype="multipart/form-data" data-turbo="true" id="dropzone-form-{{ $post->id ?? 'new' }}">

            @csrf

    @endif


    <div class="dropzone-area" id="drop-area-{{ $post->id ?? 'new' }}">

        <input type="file" name="files[]" id="file-input-{{ $post->id ?? 'new' }}" multiple accept="image/*,.pdf,.doc,.docx,.zip" class="dropzone-file-input" onchange="handleFileSelect(this, '{{ $post->id ?? 'new' }}')" />


        <label for="file-input-{{ $post->id ?? 'new' }}" class="dropzone-label">

            <div class="drop-icon">

                📁

            </div>


            <div class="drop-text">

                <strong>Drag & Drop images or files here</strong>

                <span>or click to browse from device (JPG, PNG, GIF, PDF, ZIP)</span>

            </div>

        </label>

    </div>


    <div id="file-preview-queue-{{ $post->id ?? 'new' }}" class="file-preview-queue"></div>


    @if(isset($standalone) && $standalone)

        @if(isset($post))

            <button type="submit" class="btn btn-secondary btn-sm mt-2" id="upload-btn-{{ $post->id }}" style="display:none;">

                ⚡ Upload Selected Files via Turbo

            </button>

        @endif

        </form>

    @endif

</div>
