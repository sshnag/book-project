@extends('layouts.app')

@section('content')

    <!-- Hero Section -->
    <div class="main-banner hero-bg position-relative">
        <section
            class="hero-section d-flex flex-column flex-lg-row align-items-center justify-content-between mb-5 px-3 px-lg-5"
            style="min-height: 450px;">
            <div class="hero-text flex-grow-1 pe-lg-5 text-center text-lg-start">
                <h1 class="hero-title mb-3"
                    style="font-weight: 700; font-family: 'Merriweather', serif; font-size: 2.75rem; line-height: 1.2; color: white;">
                    Biggest <span class="text-black">bookstore</span>
                </h1>
                <p class="hero-subtitle mb-4"
                    style="font-family: 'Poppins', sans-serif; font-weight: 400; color: #555; font-size: 1.125rem;">
                    Discover endless stories and lay out your imagination
                </p>


                <!-- Search Bar -->
                <form action="{{ route('search') }}" method="GET" role="search"
                    class="hero-search-form d-flex mx-auto mx-lg-0" style="max-width: 480px;">
                    <input type="search" name="query" class="form-control hero-search-input shadow-sm"
                        placeholder="Search books by title, author, or category..." aria-label="Search books"
                        value="{{ request('query') ?? '' }}" autocomplete="off" required
                        style="border-radius: 0.25rem 0 0 0.25rem; border: 1px solid #ddd;">
                    <button type="submit" class="btn btn-outline-dark px-4"
                        style="border-radius: 0 0.25rem 0.25rem 0; font-weight: 600;">
                        Search
                    </button>
                </form>
            </div>

            <div class="hero-image-wrap mt-4 mt-lg-0 text-center text-lg-end flex-shrink-0" style="max-width: 500px;">
                <img src="{{ asset('images/hero3.jpeg') }}" alt="Stack of colorful books" class="hero-image "
                    style="max-width: 100%; height: auto" />
            </div>
        </section>
    </div>

    <div class="container my-5">
        <h3 class="text-center mb-4  animate-slide">
            <strong> Top Categories</strong>
        </h3>
        <div class="row g-3">
            @foreach ($featuredCategories as $category)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <a href="#"
                        class="d-block text-decoration-none category-card p-3 rounded-4 shadow-sm text-center h-100 position-relative overflow-hidden"
                        style="background: linear-gradient(135deg, #ffc0cb, #ff69b4); transition: transform 0.3s ease;">
                        <div class="icon-wrapper mb-2">
                            <i class="bi bi-book" style="font-size: 1.5rem; color: white;"></i>
                        </div>
                        <span class="text-white fw-semibold d-block" style="font-size: 0.95rem;">
                            {{ $category->name }}
                        </span>
                        <div class="hover-overlay position-absolute top-0 start-0 w-100 h-100"
                            style="background: rgba(255,255,255,0.1); opacity: 0; transition: opacity 0.3s;"></div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Books -->
    <div class="container mb-5" id="featured">
        <h2 class="section-title animate-slide">Featured Books</h2>
        <div class="d-flex overflow-x-auto gap-3 pb-3 snap-x" role="list">
            @foreach ($featuredBooks as $book)
                <div role="listitem" class="card snap-center border-0 shadow-sm transition-transform hover-scale"
                    style="min-width: 260px;">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top rounded-top"
                        alt="{{ $book->title }}">
                    <div class="card-body">
                        <h5 class="card-title pink-text">{{ $book->title }}</h5>
                        <p class="text-muted mb-2 small">By {{ $book->author->name ?? 'Unknown' }}</p>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-pink w-100"
                            aria-label="View details of {{ $book->title }}">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Popular Books -->
    <div class="container mb-5" id="popular">
        <h2 class="section-title animate-slide">Popular Books</h2>
        <div class="d-flex overflow-x-auto gap-3 pb-3 snap-x" role="list">
            @foreach ($popularBooks as $book)
                <div role="listitem" class="card snap-center border-0 shadow-sm transition-transform hover-scale"
                    style="min-width: 260px;">
                    <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top rounded-top"
                        alt="{{ $book->title }}">
                    <div class="card-body">
                        <h5 class="card-title pink-text">{{ $book->title }}</h5>
                        <p class="text-muted mb-2 small">By {{ $book->author->name ?? 'Unknown' }}</p>
                        <a href="{{ route('user.books.show', $book->id) }}" class="btn btn-sm btn-pink-alt w-100"
                            aria-label="View details of {{ $book->title }}">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Latest Books -->
    <div class="container my-5">
        <h2 class="text-center section-title animate-slide">Latest Books</h2>
        <div class="row g-4">
            @foreach ($books as $book)
                <div class="col-md-4 fade-in">
                    <div class="card h-100 shadow-sm position-relative transition-transform hover-scale">
                        <div class="book-badge">New</div>
                        <img src="{{ asset('storage/' . $book->cover_image) }}" class="card-img-top"
                            alt="{{ $book->title }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title pink-text">{{ $book->title }}</h5>
                            <p class="text-muted mb-1">By {{ $book->author->name ?? 'Unknown' }}</p>
                            <p class="card-text small">{{ Str::limit($book->description, 100) }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="badge bg-pink text-light">⭐ {{ rand(40, 50) / 10 }}</span>
                                <a href="{{ route('user.books.show', $book->id) }}" class="btn btn-outline-pink btn-sm"
                                    aria-label="View details of {{ $book->title }}">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Related Books -->
    @if (isset($relatedBooks) && $relatedBooks->count())
        <div class="container my-5">
            <hr class="my-5 border-pink">
            <h2 class="section-title animate-slide">Related Books</h2>
            <div class="row g-4">
                @foreach ($relatedBooks as $related)
                    <div class="col-md-3 fade-in">
                        <div class="card h-100 shadow-sm transition-transform hover-scale">
                            <img src="{{ asset('storage/' . $related->cover_image) }}" class="card-img-top"
                                alt="{{ $related->title }}">
                            <div class="card-body">
                                <h6 class="card-title pink-text">{{ $related->title }}</h6>
                                <p class="text-muted small mb-2">By {{ $related->author->name ?? 'Unknown' }}</p>
                                <a href="{{ route('user.books.userShow', $related->id) }}"
                                    class="btn btn-sm btn-outline-pink w-100"
                                    aria-label="View details of {{ $related->title }}">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/book.css') }}">
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add delay to fade-in animations
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });

            // Add hover effect to cards if any .book-card-hover exist
            const cards = document.querySelectorAll('.book-card-hover');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.zIndex = '10';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.zIndex = '1';
                });
            });
        });
    </script>
@endpush
@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if ($showReplyMessage ?? false)
        Swal.fire({
            icon: 'info',
            title: 'Your message has been replied!',
            text: 'An admin has replied to your contact request.',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endpush

