<turbo-frame id="post-{{ $post->id }}">

<div class="card">

<form method="POST" action="{{ route('posts.update',$post) }}">
@csrf
@method('PUT')

<label>Title</label>
<input name="title" value="{{ $post->title }}">

<label>Description</label>
<textarea name="description">{{ $post->description }}</textarea>

<button class="btn btn-primary">Update</button>

</form>

</div>

</turbo-frame>