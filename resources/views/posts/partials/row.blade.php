<turbo-frame id="post-{{ $post->id }}">

    <div class="card post-card">

        <div class="post-header">

            <div class="post-select">

                <input
                    type="checkbox"
                    name="post_ids[]"
                    value="{{ $post->id }}"
                    class="post-checkbox"
                >

            </div>


            <div class="post-content">

                <h3 class="post-title-link">

                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>

                </h3>


                <p>

                    {{ $post->description ?: 'No description provided.' }}

                </p>


                {{-- Attachments Preview --}}

                @if($post->attachments->count())

                    <div class="row-attachments">

                        @foreach($post->attachments->take(4) as $attachment)

                            @if($attachment->file_type === 'image')

                                <img src="{{ $attachment->url }}" class="row-attachment-thumb" title="{{ $attachment->file_name }}" />

                            @else

                                <span class="row-attachment-file" title="{{ $attachment->file_name }}">📄</span>

                            @endif

                        @endforeach


                        @if($post->attachments->count() > 4)

                            <span class="row-attachment-more">+{{ $post->attachments->count() - 4 }}</span>

                        @endif

                    </div>

                @endif


                <small class="text-muted">

                    Created: {{ $post->created_at ? $post->created_at->format('d M Y, h:i A') : 'N/A' }}

                </small>

            </div>


            <div class="post-meta">

                <form method="POST" action="{{ route('posts.toggleStatus', $post) }}" data-turbo="true" style="display:inline;">

                    @csrf

                    @method('PATCH')

                    <button type="submit" class="status-badge status-{{ $post->status }} status-btn" title="Click to toggle status">

                        {{ ucfirst($post->status) }} 🔁

                    </button>

                </form>

            </div>

        </div>


        <div class="post-actions">

            <a
                href="{{ route('posts.show', $post) }}"
                class="btn btn-secondary"
            >

                👁️ View

            </a>


            <a
                href="{{ route('posts.edit', $post) }}"
                class="btn btn-warning"
            >

                ✏️ Edit

            </a>


            <form
                method="POST"
                action="{{ route('posts.destroy', $post) }}"
                data-turbo="true"
                onsubmit="return confirm('Delete this post?');"
                style="display:inline;"
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-danger"
                >

                    🗑️ Delete

                </button>

            </form>

        </div>

    </div>

</turbo-frame>