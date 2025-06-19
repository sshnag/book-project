@extends('adminlte::page')

@section('title', $book->title)

@section('content')
<div class="container my-4">
    <div class="row">
        <!-- Book Cover -->
        <div class="col-md-4">
            <img src="{{ asset('storage/' . $book->cover_image) }}" class="img-fluid rounded shadow" alt="{{ $book->title }}">
        </div>

        <!-- Book Info -->
        <div class="col-md-8">
            <h2>{{ $book->title }}</h2>
            <p><strong>Author:</strong> {{ $book->author->name ?? 'N/A' }}</p>
            <p><strong>Category:</strong> {{ $book->category->name ?? 'N/A' }}</p>
            <p><strong>Published At:</strong> {{ $book->published_at ? $book->published_at->format('F j, Y') : 'N/A' }}</p>
            <p><strong>Description:</strong></p>
            <p>{{ $book->description }}</p>

            <div class="mt-3">
                <a href="{{ route('books.download', $book->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">← Back to List</a>
            </div>

            <hr>
            <p><strong>Downloaded:</strong> {{ $book->down_count ?? 0 }} times</p>
        </div>
    </div>
</div>
@endsection
