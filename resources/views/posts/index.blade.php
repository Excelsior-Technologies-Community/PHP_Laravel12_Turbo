@extends('layouts.app')

@section('content')

<div class="top-bar">
    <h2>All Posts</h2>

    <a href="{{ route('posts.create') }}" class="btn btn-primary">
        + Create Post
    </a>
</div>

<hr>

<turbo-frame id="posts">
    @foreach($posts as $post)
        @include('posts.partials.row')
    @endforeach
</turbo-frame>

@endsection