@extends('adminlte::page')

@section('title', 'Books Management')

@section('content_header')
    <h1>Books Management</h1>
    <br>
    <a href="{{ route('admin.books.create') }}" class="btn btn-outline-dark">

        <i class="fas fa-plus"></i> Add New Book
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="book-table" class="table table-bordered tbale-hover">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Category</th>
            <th>Published At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author->name ?? 'N/A' }}</td>
            <td>{{ $book->category->name ?? 'N/A' }}</td>
            <td>{{ $book->published_at ? $book->published_at : 'N/A' }}</td>
            <td>
                <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<br>
{{ $books->links() }} <!-- Pagination links -->
@endsection
