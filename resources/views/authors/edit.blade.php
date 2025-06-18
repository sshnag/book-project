@extends('adminlte::page')

@section('content')
    <div class="container">
        <h2>Edit Author</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Please fix the following errors:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.authors.update', $author->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $author->name) }}" required>
            </div>

            <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary mt-3">Cancel</a>
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning mt-3">Edit</a>
        </form>
    </div>
@endsection
