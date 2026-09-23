<turbo-frame id="post-{{ $post->id }}">

    <div class="card">

        <h3>
            Edit Post
        </h3>

        <form
            method="POST"
            action="{{ route('posts.update', $post) }}">

            @csrf

            @method('PUT')

            <label>
                Title
            </label>

            <input
                name="title"
                value="{{ old('title', $post->title) }}"
                required
            >

            <label>
                Description
            </label>

            <textarea
                name="description"
            >{{ old('description', $post->description) }}</textarea>

            <label>
                Status
            </label>

            <select name="status">

                <option
                    value="published"
                    @selected(old('status', $post->status) === 'published')>

                    Published

                </option>

                <option
                    value="draft"
                    @selected(old('status', $post->status) === 'draft')>

                    Draft

                </option>

            </select>

            <button
                type="submit"
                class="btn btn-primary">

                Update Post

            </button>

            <a
                href="{{ route('posts.index') }}"
                class="btn btn-secondary">

                Cancel

            </a>

        </form>

    </div>

</turbo-frame>