@extends('layouts.app')
@section('title', 'login2')

@section('content')
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <p class="log">Make New User</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label for="UserName">User name:</label>
        <input type="text" class="form-control" placeholder="enter name" id="UserName" name="UserName" required>
        <label for="UserEmail">User email:</label>
        <input type="email" class="form-control" placeholder="enter email" id="UserEmail" name="UserEmail" required>
        <label for="UserPassword">Password:</label>
        <input type="password" class="form-control" placeholder="enter password" id="UserPassword" name="UserPassword" required>
        <label for="UserPassword_confirmation">Confirm password:</label>
        <input type="password" class="form-control" placeholder="confirm password" id="UserPassword_confirmation" name="UserPassword_confirmation" required>
        <label for="image">User Profile:</label>
        <input type="file" class="form-control" placeholder="choose profile" id="image" name="image" required>
        <input type="submit" value="create" class="btn btn-primary">
    </form>
@endsection
