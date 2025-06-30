@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="container my-5">
        {{-- Breadcrumb for better navigation --}}


        <div class="book-detail-card shadow rounded p-4 d-flex flex-wrap gap-4"
            style="background: #ffffff; border: 1px solid #eee;">
            <!-- Book Cover with subtle shadow, rounded corners, and aspect ratio maintained -->
            <div class="d-flex justify-content-center w-100 1-md-auto">
                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                    class="img-fluid rounded shadow" style="max-width: 250px; height: auto;  object-fit: contain;">

            </div>
            <!-- Book Info -->
            <section class="info-wrapper flex-grow-1" style="min-width: 280px;">
                <h3 class="mb-3" style="font-family: 'Merriweather', serif; font-weight: 700; color: #151515;">
                    {{ $book->title }}</h3>

                <p class="mb-1"><strong>Author: </strong> <span
                        class="text-dark">{{ $book->author->name ?? 'N/A' }}</span></p>
                <p class="mb-1"><strong>Category: </strong> <span
                        class="badge bg-info text-dark">{{ $book->category->name ?? 'N/A' }}</span></p>
                <p class="mb-3"><strong>Published: </strong> <i class="text-dark"> <time
                            datetime="{{ $book->published_at }}">{{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('F d, Y') : 'N/A' }}</time></i>
                </p>

                {{-- Book Rating Section (optional, can be extended) --}}
                @if (isset($book->rating))
                    <p>
                        <strong>Rating:</strong>
                        <span aria-label="{{ $book->rating }} out of 5 stars" role="img">
                            {!! str_repeat('★', floor($book->rating)) !!}
                            {!! str_repeat('☆', 5 - floor($book->rating)) !!}
                        </span> ({{ number_format($book->rating, 1) }})
                    </p>
                @endif

                <hr aria-hidden="true" class="my-4">

                <h4>Description</h4>
                <article class="description mb-4" tabindex="0" style="line-height: 1.6; color: #000000;">
                    {!! nl2br(e($book->description)) !!}
                </article>

                {{-- Tags for category and author    --}}
                <div class="mb-3">
                    @if ($book->tags && count($book->tags) > 0)
                        <strong>Tags:</strong>
                        @foreach ($book->tags as $tag)
                            <span class="badge bg-dark">{{ $tag->name }}</span>
                        @endforeach
                    @endif
                </div>

                {{-- Buttons side by side --}}
                <div class="mt-4 d-flex gap-3 align-items-center">
                    @can('download books')

                        <a href="{{ route('user.books.download', $book->id) }}"
                            class="btn btn-outline-dark btn-back rounded-pill px-4" {{ $book->title }}">
                            <i class="fas fa-download me-2" aria-hidden="true"></i> Download PDF
                        </a>
                    @else
                        <p class="text-danger mt-3 mb-0" role="alert">Please <a href="{{ route('login') }}"
                                class="text-decoration-underline">log in</a> to download this book.</p>
                    @endcan

                    <a href="{{ route('home') }}" class="btn btn-dark btn-back rounded-pill">
                        Back
                    </a>
                </div>
            </section>
        </div>

        {{-- Related Books Section (stub for future) --}}
        <section class="related-books mt-5">
            <h3 class="mb-4" style="font-family: 'Poppins', sans-serif; font-weight: 600; color: #34495e;">You might also
                like</h3>
            <div class="d-flex gap-3 overflow-auto">
                {{-- Example stub: you can dynamically fill this with actual data --}}
                {{-- <x-book-card :book="$relatedBook" /> --}}
                <p class="text-muted">Related books coming soon...</p>
            </div>
        </section>
    </div>
@endsection

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/book.css') }}">
@endpush
