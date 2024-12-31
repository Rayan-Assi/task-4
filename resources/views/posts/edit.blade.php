@extends('layouts.app')
@section('title', 'Update Post')

@section('content')
    <form action="{{ route('post.update', $posts->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h1>Update Post </h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3">
            <label for="posttitle" class="form-label">Title</label>
            <input type="text" class="form-control" value="{{ $posts->title }}" name="title" id="posttitle" placeholder="Title" required>
        </div>
        <div class="mb-3">
            <label for="postdescription" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="postdescription" placeholder="Post description" rows="3">{{ old('description', $posts->description) }}</textarea>
        </div>
        <div class="mb-3">
            <div>
                <p>Old Image:</p>
                <img src="/images/posts/{{ $posts->image }}" alt="Old image" width="75px">
            </div>
            <label for="choosingfile" class="form-label">Update Image (optional)</label>
            <input class="form-control" type="file" name="image" id="choosingfile">
        </div>
        <div class="mb-3">
            <label for="category">Choose a Category:</label>
            @php
                $categories = DB::table('categories')->get();
                $selectedCg = $posts->category_id;
            @endphp
            <select class="form-select" id="category" name="category_id" aria-label="Default select example">
                @forelse ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $selectedCg ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                @empty
                    <p>There are no categories.</p>
                @endforelse
            </select>
            <label for="tags">Choose Tags:</label>
            @php
                $tags = DB::table('tags')->get();
                $selectedTags = old('tags', $posts->tags->pluck('id')->toArray() ?? []);
            @endphp
            <select class="form-select" name="tags[]" id="tags" multiple aria-label="Default select example">
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                        {{ $tag->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" value="Send" class="btn btn-primary">
        </div>
    </form>
@endsection
