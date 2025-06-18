@extends('adminlte::page')
@section('title', 'Edit Book')

@section('content_header')
    <h1>Edit Book</h1>
@endsection

@section('content')
    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.books.form', ['book' => $book])
        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
