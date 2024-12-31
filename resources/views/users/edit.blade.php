@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <p class="log">Update User Information</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label for="UserName">User Name:</label>
        <input type="text" class="form-control" placeholder="Enter Name" value="{{ $user->name }}" id="UserName" name="UserName" required>
        <label for="UserEmail">User Email:</label>
        <input type="email" class="form-control" placeholder="Enter Email" value="{{ $user->email }}" id="UserEmail" name="UserEmail" required>
        <label for="UserPassword">Password (leave blank if not changing):</label>
        <input type="password" class="form-control" placeholder="Enter Password" id="UserPassword" name="UserPassword">
        <label for="UserPassword_confirmation">Confirm Password:</label>
        <input type="password" class="form-control" placeholder="Confirm Password" id="UserPassword_confirmation" name="UserPassword_confirmation">
        <p>Old Image:</p>
        @php
            $im = $user->image;
        @endphp
        <img src="/images/users/{{ $im }}" alt="" width="100px" height="125px">
        <label for="image">User Profile:</label>
        <input type="file" class="form-control" placeholder="Choose Profile" id="image" name="image">

        <input type="submit" value="Update" class="btn btn-primary">
    </form>
@endsection
