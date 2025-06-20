@extends('adminlte::page')
@section('title', 'Categories')
@section('content_header')
    <h1>Categories</h1>
    <br>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-dark">Add Category</a>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $cat)
                @php
                    // Debugging line - remove after fixing
                    if (!is_object($cat)) {
                        logger()->error('Non-object in categories loop', ['item' => $cat]);
                        continue;
                    }
                @endphp

                <tr>
                    <td>{{ $cat->name ?? 'N/A' }}</td>
                    <td>
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>
{{ $categories->links()}} <!-- Pagination links -->

@endsection
