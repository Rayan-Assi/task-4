@extends('layouts.app')

@section('title', 'Post Details')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('images/users/' . $post->user->image) }}" class="rounded-circle mr-2"
                alt="{{ $post->user->name }}" width="50" height="50">
            <h4 class="ml-2">Posted by: {{ $post->user->name }}</h4>
        </div>
        <h1>Title :{{ $post->title }}</h1>
        <img src="/images/posts/{{ $post->image }}" alt="{{ $post->title }}" width="300px" height="300px">
        <h4>Category :{{ $post->category->title }}</h4>
        <p>Description:</p>
        <p>{{ $post->description }}</p>
        <h5>Selected Tags:</h5>
        <p>
            @foreach ($post->tags as $tag)
                {{ $tag->title }}{{ !$loop->last ? ', ' : '' }}
            @endforeach
        </p>

        <h5>Comments:</h5>
        <div class="container">
            @forelse ($post->comments as $comment)
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('images/users/' . $comment->user->image) }}" class="img-fluid rounded-start"
                                alt="{{ $comment->user->name }}">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $comment->user->name }}</h5>
                                <p class="card-text">{{ $comment->description }}</p>
                                <p class="card-text"><small class="text-body-secondary">Commented on
                                        {{ $comment->created_at->format('M d, Y') }}</small></p>
                                @can('update', $comment)
                                    <a
                                        href="{{ route('comment.edit', ['post' => $post->id, 'id' => $comment->id]) }}">Update</a>
                                @endcan
                                @can('delete', $comment)
                                    <form action="{{ route('comment.destroy', ['post' => $post->id, 'id' => $comment->id]) }}"
                                        method="POST" id="delete-form-{{ $comment->id }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $comment->id }}').submit();">Delete</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>There are no comments.</p>
            @endforelse
        </div>

        <h3>Add a Comment:</h3>
        <form action="{{ route('comment.store', $post->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="description">Comment:</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Return</a>
    </div>
@endsection
