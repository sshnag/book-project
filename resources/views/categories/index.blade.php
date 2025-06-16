@extends('adminlte::page')
@section('title', 'Categories')

@section('content_header')
    <h1>Categoried</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-success">Add Category</a>
@endsection

@section('content')
    @include('partials.flash')
    <table class="table table-bordered">
        <thead><tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline-block">@csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
