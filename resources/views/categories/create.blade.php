@extends('adminlte::page')

@section('content')
    <div class="container">
        <h2>Add New Category</h2>

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

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" >
            </div>

            <button type="submit" class="btn btn-outline-dark mt-3">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mt-3">Back</a>
        </form>
    </div>
@endsection
