@extends('layouts.app')

@section('title', 'update_tag')

@section('content')
    <form action="{{ route('tag.update', $tag->id) }}" method="POST" enctype="multipart/form-data">
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
        <input type="text" class="form-control" value="{{ $tag->title }}" placeholder="enter title" id="title"
            name="title" required>
        <input type="submit" value="update" class="btn btn-primary">

    </form>

@endsection
