@extends('layouts.app')

@section('content')

<div class="top-bar">

    <h2>✏️ Edit Post #{{ $post->id }}</h2>

    <a
        href="{{ route('posts.index') }}"
        class="btn btn-secondary">

        ← Back to Posts

    </a>

</div>

<hr>

<form
    method="POST"
    action="{{ route('posts.update', $post) }}"
    enctype="multipart/form-data"
    data-turbo="false"
>

    @csrf

    @method('PUT')

    <div class="form-group">

        <label>

            Title

        </label>

        <input
            name="title"
            value="{{ old('title', $post->title) }}"
            required
        >

    </div>


    <div class="form-group">

        <label>

            Description

        </label>

        <textarea
            name="description"
        >{{ old('description', $post->description) }}</textarea>

    </div>


    <div class="form-group">

        <label>

            Status

        </label>

        <select name="status">

            <option
                value="published"
                @selected(old('status', $post->status) === 'published')>

                🟢 Published

            </option>

            <option
                value="draft"
                @selected(old('status', $post->status) === 'draft')>

                📝 Draft

            </option>

        </select>

    </div>


    {{-- Upload New Attachments --}}

    <div class="form-group">

        <label>

            📁 Upload Attachments (Drag & Drop)

        </label>

        @include('attachments.partials.dropzone', ['post' => $post])

    </div>


    {{-- Existing Attachments Grid --}}

    <div class="form-group">

        <label>

            🖼️ Current Attachments

        </label>

        @include('attachments.partials.list', ['post' => $post])

    </div>


    <div class="form-actions">

        <button
            type="submit"
            class="btn btn-primary btn-lg">

            💾 Update Post

        </button>

    </div>

</form>

@endsection