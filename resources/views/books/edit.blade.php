@extends('adminlte::page')

@section('title', 'Edit Book')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">Edit Book</h2>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-secondary">Cancel</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>There were some errors:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Book Edit form --}}
        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Book Title</label>
                <input type="text" name="title" value="{{ old('title', $book->title) }}" class="form-control" required>
            </div>

            {{-- Author --}}
            <div class="mb-3">
                <label for="author_id" class="form-label">Author</label>
                <select name="author_id" class="form-select" required>
                    <option value="" disabled>Select an author</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}" {{ $book->author_id == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Category select --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="" disabled>Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $book->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Published date --}}
          <div class="form-group">
                        <label for="published_at">Published Date</label>
                        <input type="date" name="published_at" id="published_at" class="form-control"
                            value="{{ old('published_at', $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('Y-m-d') : '') }}">
                    </div>


            {{-- Description --}}
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" rows="5" class="form-control" required>{{ old('description', $book->description) }}</textarea>
            </div>

            {{-- Image Upload --}}
            <div class="mb-3">
                <label for="cover_image">Cover Image</label>
                        @if ($book->cover_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Current Cover"
                                    style="max-width: 200px; height: auto;">
                            </div>
                        @endif
                        <input type="file" name="cover_image" class="form-control-file" accept="image/*">
                        @error('cover_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
            </div>

            {{-- File Upload --}}
            <div class="mb-3">
                <label class="form-label">Book PDF File</label>
                @if ($book->file_path)
                    <div class="mb-2">
                        <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank">View Current PDF</a>
                    </div>
                @endif
                <input type="file" name="file" class="form-control">
                <div class="d-grid gap-2 d-md-block mt-4">
                    {{-- Update Button --}}
                    <button type="submit" class="btn btn-outline-dark">Update Book</button>
                </div>
            </div>



        </form>
    </div>
@endsection
