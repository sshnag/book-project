@extends('adminlte::page')
@section('title', 'Edit Book')

@section('content_header')
    <h1>Edit Book</h1>
@endsection

@section('content')
    <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('books.create', ['book' => $book])
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
