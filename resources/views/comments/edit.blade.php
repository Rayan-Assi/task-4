@extends('layouts.app')

@section('title', 'Edit Comment')

@section('content')
<h5>Edit Comment</h5>
<div class="container">
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ asset('images/users/' . $comment->user->image) }}" class="img-fluid rounded-start" alt="{{ $comment->user->name }}">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $comment->user->name }}</h5>
                    <p class="card-text">Commented on {{ $comment->created_at->format('M d, Y') }}</p>
                    
                    <!-- Form for editing the comment -->
                    <form action="{{ route('comment.update', ['post' => $post->id, 'id' => $comment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="description">Comment:</label>
                            <textarea class="form-control" id="description" name="description" required>{{ $comment->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
