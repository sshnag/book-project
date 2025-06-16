@extends('adminlte::page')
@section('title', 'Add Book')

@section('content_header')
    <h1>Add New Book</h1>
@endsection

@section('content')
<form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @include('books.form')
    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
