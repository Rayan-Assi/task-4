@extends('layouts.app')

@section('title', 'create_category')

@section('content')
    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
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
        <input type="text" class="form-control" placeholder="enter title" id="title" name="title" required>
        <label for="image">Image:</label>

        <input type="file" class="form-control" placeholder="choose image" id="image" name="image" required>
        <input type="submit" value="create" class="btn btn-primary">

    </form>
@endsection
