@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="container my-5">
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
            <p><strong>Published:</strong> {{ $book->published_at ? $book->published_at->format('F j, Y') : 'N/A' }}</p>

            <hr>
            <h5>Description</h5>
            <p>{{ $book->description }}</p>

            <a href="{{ route('books.download', $book->id) }}" class="btn btn-primary mt-3">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <a href="{{ route('home') }}" class="btn btn-link mt-3">← Back to Home</a>
        </div>
    </div>
</div>
@endsection
    