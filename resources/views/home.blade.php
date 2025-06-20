@extends('layouts.app')

@section('content')

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{ asset('images/hero1.jpg') }}" class="d-block w-100" alt="Hero 1" style="height: 400px; object-fit: cover;">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-black">Read. Learn. Grow.</h2>
        <p class="text-black">Explore a world of books curated just for you.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="{{ asset('images/hero2.jpg') }}" class="d-block w-100" alt="Hero 2" style="height: 400px; object-fit: cover;">
      <div class="carousel-caption d-none d-md-block">
        <h2 class="text-black">Discover New Titles</h2>
        <p class="text-black">Handpicked selections from various genres.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon-black"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon-black"></span>
  </button>
</div>

<!-- Search Bar -->
{{-- <div class="container mb-4">
  <form action="{{ route('search') }}" method="GET" class="d-flex justify-content-center">
    <input type="text" name="query" class="form-control w-50 me-2" placeholder="Search for books...">
    <button type="submit" class="btn btn-primary">Search</button>
  </form>
</div> --}}

<!-- Featured Books (Horizontal Scroll) -->
<div class="container mb-5">
  <h4 class="mb-3">Featured Books</h4>
  <div class="d-flex overflow-auto pb-3 data-mdb-animation-delay">
    @foreach($featuredBooks as $book)
<div class="card me-3 book-card fade-in" style="min-width: 200px;">
        <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $book->title }}">
        <div class="card-body">
          <h6 class="card-title">{{ $book->title }}</h6>
          <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary mt-2">View</a>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Popular Books (Horizontal Scroll) -->
<div class="container mb-5">
  <h4 class="mb-3">Popular Books</h4>
  <div class="d-flex overflow-auto pb-3">
    @foreach($popularBooks as $book)
<div class="card me-3 book-card fade-in" style="min-width: 200px;">
        <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $book->title }}">
        <div class="card-body">
          <h6 class="card-title">{{ $book->title }}</h6>
          <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-success mt-2">View</a>
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Latest Books Grid -->
<div class="container my-5">
  <h3 class="text-center mb-4">Latest Books</h3>
  <div class="row">
    @foreach($books as $book)
      <div class="col-md-4 mb-4">
        <div class="card h-150 shadow-sm" id="book">
          <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}" style="height: 300px; object-fit: cover;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $book->title }}</h5>
            <p class="card-subtitle mb-2 text-muted">By {{ $book->author->name ?? 'Unknown' }}</p>
            <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
            <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-dark mt-auto">View Details</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('css/book.css') }}">
@endpush
