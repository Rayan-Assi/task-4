@extends('layouts.app')

@section('title', 'add post')

@section('content')
    <form action="{{ route('post.store') }}" class="form1" method="POST" enctype="multipart/form-data">
        @csrf
        <h1>Add New Post </h1>
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
            <input type="text" class="form-control" name="title" id="posttitle" placeholder="title " required>
        </div>
        <div class="mb-3">
            <label for="postdescription" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="postdescription" placeholder="post description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="choosingflie" class="form-label">choose image files</label>

            <input class="form-control" type="file" name="image" multiple id="choosingflie" required>
        </div>
        <label for="category">Choose a Category:</label>
        @php
            $categories = DB::table('categories')->get();
        @endphp
        <select class="form-select" id="category" name="category_id" aria-label="Default select example">
            @forelse ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
            @empty
                <p>there is no categories</p>
            @endforelse
        </select>
        {{--  --}}
        @php
        
        $tags = DB::table('tags')->get();
    @endphp
    
    <label for="tags">Choose Tags:</label>
    <select class="form-select" name="tags[]" id="tags" multiple aria-label="Default select example">
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->title}}</option>
        @endforeach
    </select>
    
        {{--  --}}
        <div class="d-grid gap-2">
            <input type="submit" value="Send" class="btn btn-primary " required>
        </div>
    </form>
@endsection
