<turbo-frame id="post-{{ $post->id }}">

    <div class="card">

        <div style="
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:15px;
        ">

            <div style="flex:1;">

                <h3>
                    {{ $post->title }}
                </h3>

                <p>
                    {{ $post->description ?: 'No description provided.' }}
                </p>

                <small style="color:#94a3b8;">

                    Created:
                    {{ $post->created_at->format('d M Y, h:i A') }}

                </small>

            </div>

            <span class="status-badge status-{{ $post->status }}">

                {{ ucfirst($post->status) }}

            </span>

        </div>


        {{-- Post Actions --}}
        <div style="margin-top:15px;">

            {{-- View Post --}}
            <a
                href="{{ route('posts.show', $post) }}"
                class="btn btn-secondary"
                data-turbo-frame="_top">

                View

            </a>


            {{-- Edit Post --}}
            <a
                href="{{ route('posts.edit', $post) }}"
                class="btn btn-warning">

                Edit

            </a>


            {{-- Delete Post --}}
            <form
                method="POST"
                action="{{ route('posts.destroy', $post) }}"
                style="display:inline;">

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete this post?')">

                    Delete

                </button>

            </form>

        </div>

    </div>

</turbo-frame>