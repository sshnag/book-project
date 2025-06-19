@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-white shadow p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold text-indigo-600">Book Blog</div>
            <div class="space-x-4">
                <a href="#" class="text-gray-600 hover:text-indigo-500">Home</a>
                <a href="#contact" class="text-gray-600 hover:text-indigo-500">Contact Us</a>
                {{-- <form action="{{ route('search') }}" method="GET" class="inline">
                    <input type="text" name="query" placeholder="Search books..." class="border p-1 rounded">
                    <button type="submit" class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600">Search</button>
                </form> --}}
            </div>
        </div>
    </nav>

    <!-- Book Cards -->
    <div class="container mx-auto py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($books as $book)
                <div class="bg-white p-5 rounded-lg shadow hover:shadow-xl transition duration-300">
                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-48 object-cover rounded mb-4">
                    <h3 class="text-lg font-bold">{{ $book->title }}</h3>
                    <p class="text-sm text-gray-500 mb-2">By {{ $book->author->name }}</p>
                    <p class="text-sm text-gray-600 line-clamp-3 mb-4">{{ $book->description }}</p>
                    <a href="{{ route('admin.books.show', $book->id) }}" class="inline-block bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">View Details</a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Contact Us -->
    <div id="contact" class="bg-white py-10 shadow-inner">
        <div class="container mx-auto text-center">
            <h2 class="text-2xl font-semibold text-indigo-600 mb-4">Contact Us</h2>
            <p class="text-gray-600">Email us at <a href="mailto:support@bookblog.com" class="text-indigo-500">support@bookblog.com</a> or call +959-123-456-789.</p>
        </div>
    </div>
</div>
@endsection
