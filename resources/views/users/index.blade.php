@extends('layouts.app')

@section('title', 'UsersTable')

@section('content')
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Update User</th>
                <th scope="col">Delete User</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @forelse ($users as $user)
                @if (!$user->is_admin)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        @if ($user->image)
                            <td>
                                <img src="/images/users/{{ $user->image }}" alt="Profile Picture" width="100px">
                            </td>
                        @else
                            <td>No Image</td>
                        @endif
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href='{{ route('user.edit', $user->id) }}'>
                                <button type="button" class="btn btn-success">Update</button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="6">There are no users</td>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('user.create') }}"><button class="btn btn-secondary">Create New User</button>
    </a>
    <div>    <a href="{{ route('posts.index') }}"><button class="btn btn-outline-secondary">Back to posts</button></a>
</div>

@endsection
