@extends('layouts.app')

@section('content')

<div class="top-bar">

    <h2>✨ Create New Post</h2>

    <a
        href="{{ route('posts.index') }}"
        class="btn btn-secondary">

        ← Back to Posts

    </a>

</div>

<hr>

<form
    method="POST"
    action="{{ route('posts.store') }}"
    enctype="multipart/form-data"
    data-turbo="false"
>

    @csrf

    <div class="form-group">

        <label>

            Title

        </label>

        <input
            name="title"
            value="{{ old('title') }}"
            placeholder="Enter post title"
            required
        >

    </div>


    <div class="form-group">

        <label>

            Description

        </label>

        <textarea
            name="description"
            placeholder="Write detailed post content..."
        >{{ old('description') }}</textarea>

    </div>


    <div class="form-group">

        <label>

            Status

        </label>

        <select name="status">

            <option
                value="published"
                @selected(old('status', 'published') === 'published')>

                🟢 Published

            </option>

            <option
                value="draft"
                @selected(old('status') === 'draft')>

                📝 Draft

            </option>

        </select>

    </div>


    {{-- Attachments Upload Dropzone --}}

    <div class="form-group">

        <label>

            📁 Attachments (Images & Files)

        </label>

        @include('attachments.partials.dropzone', ['post' => null])

    </div>


    <div class="form-actions">

        <button
            type="submit"
            class="btn btn-primary btn-lg">

            💾 Save Post & Attachments

        </button>

    </div>

</form>

@endsection