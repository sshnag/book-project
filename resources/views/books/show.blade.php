@extends('adminlte::page')
@section('title', 'Book Details')

@section('content_header')
    <h1>Book Detail</h1>
@endsection

@section('content')
<p><strong>Title:</strong> {{ $book->title }}</p>
<p><strong>Description:</strong> {{ $book->description }}</p>
<p><strong>Author:</strong> {{ $book->author->name }}</p>
<p><strong>Category:</strong> {{ $book->category->name }}</p>
<p><strong>Downloads:</strong> {{ $book->download_count }}</p>
@if($book->cover_image)
    <p><img src="{{ asset('storage/'.$book->cover_image) }}" height="150"></p>
@endif
<a href="{{ route('books.index') }}" class="btn btn-secondary">Back</a>
@endsection
