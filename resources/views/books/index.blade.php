@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Books</h2>

    <div class="row">
        @forelse($books as $book)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($book->description, 80) }}</p>
                        <a href="#" class="btn btn-primary btn-sm">Details</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No books available.</p>
        @endforelse
    </div>

    <div class="d-flex justify-content-center">
        {{ $books->links() }}
    </div>
</div>
@endsection
