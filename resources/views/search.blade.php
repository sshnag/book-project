@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3 class="section-title text-center mb-4">Search Results</h3>

    @if($books->count())
        <div class="list-group">
            @foreach($books as $book)
                <div class="list-group-item py-4 px-3 mb-3 shadow-sm rounded d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between transition-transform hover-scale search-result-item">
                    <div class="d-flex align-items-start gap-3">
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                             class="search-result-img rounded">
                        <div>
                            <h5 class="mb-1 pink-text">{{ $book->title }}</h5>
                            <p class="mb-1 text-muted small">
                                By {{ $book->author->name ?? 'Unknown' }} | {{ $book->category->name ?? 'Uncategorized' }}
                            </p>
                            <p class="mb-0 small description-text">{{ Str::limit($book->description, 150) }}</p>
                        </div>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('user.books.show', $book->id) }}" class="btn btn-sm btn-outline-pink" aria-label="View details of {{ $book->title }}">View</a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4 text-center">
            <strong>
                {{ $books->appends(request()->query())->links() }}
            </strong>
        </div>
    @else
        <div class="alert alert-warning text-center bg-dark text-pink-border">
            No books found matching your search criteria.
        </div>
    @endif
</div>

<a href="javascript:void(0)" onclick="history.back()" class="btn-back mt-4 mb-5 d-flex" role="button" >← Back</a>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/book.css') }}">
@endpush
