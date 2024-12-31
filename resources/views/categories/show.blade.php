@extends('layouts.app')

@section('title', 'Posts')

@section('content')

    <div class="container container_post">

        <div class="card mb-3">
            <img src="/images/categories/{{ $category->image }}" alt="" class="in_img" width="300px" height="200px">

            <div class="card-body">
                <h5>Title :{{ $category->title }}</h5>
            </div>
        </div>

    </div>
    <div> <a href="{{ route('posts.index') }}"><button class="btn btn-outline-secondary">Back to posts</button></a>
    </div>


@endsection
