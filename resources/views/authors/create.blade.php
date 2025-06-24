@extends('adminlte::page')

@section('content')
    <div class="container">
        <h2>Add New Author</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> <br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.authors.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" >
            </div>

            <button type="submit" class="btn btn-outline-dark mt-3">Create Author</button>
            <a href="javascript:void(0)" onclick="history.back()"  class="btn btn-secondary mt-3">Back</a>
        </form>
    </div>
@endsection
