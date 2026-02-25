<turbo-frame id="post-{{ $post->id }}">

<div class="card">

    <h3>{{ $post->title }}</h3>
    <p>{{ $post->description }}</p>

    <a href="{{ route('posts.edit',$post) }}"
       class="btn btn-warning">Edit</a>

    <form method="POST"
          action="{{ route('posts.destroy',$post) }}"
          style="display:inline;">
        @csrf
        @method('DELETE')

        <button class="btn btn-danger">
            Delete
        </button>
    </form>

</div>

</turbo-frame>