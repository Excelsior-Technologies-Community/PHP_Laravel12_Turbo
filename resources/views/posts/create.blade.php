@extends('layouts.app')

@section('content')

<h2>Create Post</h2>
<hr>

<form method="POST" action="{{ route('posts.store') }}">
@csrf

<label>Title</label>
<input name="title" placeholder="Enter title">

<label>Description</label>
<textarea name="description" placeholder="Write something..."></textarea>

<button class="btn btn-primary">Save Post</button>

</form>

@endsection