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

                <h3>
                    {{ $post->title }}
                </h3>

                <p>

                    {{ $post->description ?: 'No description provided.' }}

                </p>

                <small>

                    Created:
                    {{ $post->created_at->format('d M Y, h:i A') }}

                </small>

            </div>


            <div class="post-meta">

                <span
                    class="status-badge status-{{ $post->status }}"
                >
                    {{ ucfirst($post->status) }}
                </span>

            </div>

        </div>


        <div class="post-actions">

            <a
                href="{{ route('posts.show', $post) }}"
                class="btn btn-secondary"
            >
                View
            </a>


            <a
                href="{{ route('posts.edit', $post) }}"
                class="btn btn-warning"
            >
                Edit
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
                    Delete
                </button>

            </form>

        </div>

    </div>

</turbo-frame>