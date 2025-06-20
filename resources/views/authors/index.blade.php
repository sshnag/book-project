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
    <table class="table table-striped">
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
                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')<button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $authors->links() }} <!-- Pagination links -->
@endsection
