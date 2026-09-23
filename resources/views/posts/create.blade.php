@extends('layouts.app')

@section('content')

<div class="top-bar">

    <h2>Create Post</h2>

    <a
        href="{{ route('posts.index') }}"
        class="btn btn-secondary">

        ← Back to Posts

    </a>

</div>

<hr>

<form
    method="POST"
    action="{{ route('posts.store') }}">

    @csrf

    <label>
        Title
    </label>

    <input
        name="title"
        value="{{ old('title') }}"
        placeholder="Enter post title"
        required
    >

    <label>
        Description
    </label>

    <textarea
        name="description"
        placeholder="Write something..."
    >{{ old('description') }}</textarea>

    <label>
        Status
    </label>

    <select name="status">

        <option
            value="published"
            @selected(old('status', 'published') === 'published')>

            Published

        </option>

        <option
            value="draft"
            @selected(old('status') === 'draft')>

            Draft

        </option>

    </select>

    <button
        type="submit"
        class="btn btn-primary">

        Save Post

    </button>

</form>

@endsection