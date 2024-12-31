@extends('layouts.app')
@section('title', 'login')

@section('content')
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <p class="log">Login Website</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <label for="email">Enter Email:</label>
        <input type="email" class="form-control" id="email" placeholder="enter your email" name="email" required>
        <label for="password">Enter Password:</label>
        <input type="password" class="form-control" id="password" placeholder="enter your password" name="password" required>
        <input type="submit" value="login" class="btn btn-primary">

    </form>
@endsection
