@extends('layouts.app')

@section('title', 'categories')

@section('content')





    <table class="table">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Image</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->title }}</td>
                    <td>
                        @if ($category->image)
                            <img src="{{ asset('images/categories/' . $category->image) }}" alt="Category Image"
                                width="100">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-success" href="{{ route('category.edit', $category->id) }}">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-primary mb-4" href="{{ route('category.create') }}">Add New Category</a>


    <div> <a href="{{ route('posts.index') }}"><button class="btn btn-outline-secondary">Back to posts</button></a>
    </div>


@endsection
