@extends('adminlte::page')

@section('title', 'Books Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">

        <a href="{{ route('admin.books.create') }}" class="btn btn-outline-warning font-weight-bold" style="border-radius: 50px;">
            <i class="fas fa-plus"></i> Add New Book
        </a>
    </div>

@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table id="book-table" class="table table-bordered table-hover mb-0">
                <thead class="thead-light text-uppercase text-secondary small">
                    <tr>
                        <th class="font-weight-bold" style="width: 25%;">Title</th>
                        <th class="font-weight-bold" style="width: 20%;">Author</th>
                        <th class="font-weight-bold" style="width: 20%;">Category</th>
                        <th class="font-weight-bold" style="width: 20%;">Published At</th>
                        <th class="font-weight-bold text-center" style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr class="align-middle">
                            <td class="pl-4 font-weight-semibold">{{ $book->title }}</td>
                            <td>{{ $book->author->name ?? 'N/A' }}</td>
                            <td>{{ $book->category->name ?? 'N/A' }}</td>
                            <td>{{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('M d, Y') : 'N/A' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-sm btn-info" title="View Book">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-primary" title="Edit Book">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this book?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Delete Book">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white d-flex justify-content-end">
            {{ $books->links() }}
        </div>
    </div>



@endsection
