@extends('layouts.app')

@section('title', 'Posts')

@section('content')

    <a href="{{ route('post.create') }}"><button class="btn btn-outline-secondary">Add New Post</button></a>
    @can('manageUser')
        <a href="{{ route('users.index') }}"><button class="btn btn-outline-secondary">Show Users</button></a>
        <a href="{{ route('categories.index') }}"><button class="btn btn-outline-secondary">Show Categories</button></a>
        <a href="{{ route('tags.index') }}"><button class="btn btn-outline-secondary">Show Tags</button></a>
    @endcan

    <div class="container container_post">
        @forelse ($posts as $post)
            <div class="card mb-3">

                <div class="d-flex align-items-center mb-2">
                    <img src="{{ asset('images/users/' . $post->user->image) }}" alt="{{ $post->user->name }}"
                        class="rounded-circle mr-2" width="30" height="30">
                    <small>{{ $post->user->name }}</small>
                </div>


                <img src="/images/posts/{{ $post->image }}" alt="" class="in_img" width="300px" height="200px">

                <div class="card-body">
                    <h1>{{ $post->title }}</h1>
                    @php
                        $categoryTitle = DB::table('categories')
                            ->where('id', $post->category_id)
                            ->value('title');
                    @endphp
                    <a href="{{ route('category.show',$post->category_id) }}" style="text-decoration: none;  color: black;
">
                        <h6>Category: {{ $categoryTitle }}</h6>
                    </a>

                    <p>Tags:
                        @foreach ($post->tags as $tag)
                            {{ $tag->title }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </p>
                    <p>{{ $post->description }}</p>

                    @can('update', $post)
                        <a href="{{ route('post.edit', $post->id) }}"><button
                                class="btn btn-outline-success">Update</button></a>
                    @endcan
                    @can('delete', $post)
                        <form action="{{ route('post.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </form>
                    @endcan
                    <a href="{{ route('post.show', $post->id) }}" class="btn btn-outline-primary"><i class="fa fa-eye"
                            aria-hidden="true"></i> Show More</a>
                </div>
            </div>
        @empty
            <h3>There are no posts.</h3>
        @endforelse
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <input type="submit" value="Logout" class="btn btn-outline-primary">
    </form>

@endsection
