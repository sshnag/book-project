@extends('adminlte::page')
@section('title', 'Authors')
@section('content_header')
    <h1>Authors</h1>
    <a href="{{ route('admin.authors.create') }}" class="btn btn-outline-dark">Add Author</a>
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                    <td>
                        <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
