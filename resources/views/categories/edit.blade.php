@extends('layouts.app')
@section('title', 'Update Category')

@section('content')
    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label for="title">Title:</label>
        <input type="text" class="form-control" placeholder="Enter title" value="{{ $category->title }}" id="title" name="title" required>
        
        <label for="image">Image:</label>
        <p>Old image:</p>
        <img src="/images/categories/{{ $category->image }}" alt="Category image" width="100px" height="125px">
        
        <input type="file" class="form-control" placeholder="Choose image" id="image" name="image">
        
        <input type="submit" value="Update" class="btn btn-primary">
    </form>
@endsection
