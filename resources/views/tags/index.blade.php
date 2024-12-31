@extends('layouts.app')

@section('title', 'tags')

@section('content')
    @php

    @endphp
    <table class="table">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tag Title</th>
                <th scope="col">Update Tag</th>
                <th scope="col">Delete Tag</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @forelse ($tag as $t)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $t->title }}</td>

                    <td><a href='{{ route('tag.edit', $t->id) }}'><button type="button"
                                class="btn btn-success">Update</button></a></td>
                    <td>
                        <form action="{{ route('tag.destroy', $t->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>

            @empty
                </tr>
                <tr>
                    <td colspan="6">There are no tags</td>
            @endforelse
        </tbody>
    </table>
    <a href="{{ route('tag.create') }}"><button type="button" class="btn btn-secondary">Create New Tag
        </button></a>
    <a href="{{ route('posts.index') }}"><button class="btn btn-outline-secondary">Back to posts</button></a>


@endsection
