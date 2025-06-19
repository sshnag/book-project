@extends('layouts.app')

@section('content')
<div class="container mx-auto py-10">
    <div class="bg-white shadow p-6 rounded-lg max-w-3xl mx-auto">
        <img src="{{ asset('storage/' . $book->image) }}" class="w-full h-64 object-cover rounded mb-4">
        <h2 class="text-2xl font-bold mb-2">{{ $book->title }}</h2>
        <p class="text-gray-500 mb-4">By {{ $book->author }}</p>
        <p class="text-gray-700 mb-4">{{ $book->description }}</p>

        <a href="{{ asset('storage/' . $book->pdf_file) }}" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600" download>Download PDF</a>
    </div>
</div>
@endsection
