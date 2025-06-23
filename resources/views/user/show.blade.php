@extends('layouts.app')

@section('title', $book->title)
@section('content')
<div class="container my-5">
    <div class="book-detail-card shadow">
        <!-- Book Cover -->
        <div class="cover-wrapper" aria-label="Book cover of {{ $book->title }}">
            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}">
        </div>

        <!-- Book Info -->
        <div class="info-wrapper">
            <h2>{{ $book->title }}</h2>
            <p><strong>Author: </strong>{{ $book->author->name ?? 'N/A' }}</p>
            <p><strong>Category: </strong>{{ $book->category->name ?? 'N/A' }}</p>
            <p><strong>Published: </strong>{{ $book->published_at ?? 'N/A' }}</p>

            <hr aria-hidden="true">

            <h5>Description</h5>
            <div class="description" tabindex="0">{{ $book->description }}</div>

            @auth
                <a href="{{ route('user.books.download', $book->id) }}" class="btn-download mt-3" aria-label="Download PDF of {{ $book->title }}">
                    <i class="fas fa-download" aria-hidden="true"></i> Download PDF
                </a>
            @else
                <p class="text-danger mt-4">Please <a href="{{ route('login') }}">log in</a> to download this book.</p>
            @endauth

            <a href="{{ route('home') }}" class="btn-back mt-3" aria-label="Back to home page">← Back to Home</a>
        </div>
    </div>
</div>
@endsection
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(path: 'css/book.css') }}">
@endpush
