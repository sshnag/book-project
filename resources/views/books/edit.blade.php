@extends('adminlte::page')

@section('title', 'Edit Book')

@section('content')
    <div class="container book-form">
        <h2 class="mb-4">Edit Book</h2>

        <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title">Title*</label>
                        <input type="text" name="title" id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $book->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description">Description*</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                            rows="4">{{ old('description', $book->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Author -->
                    <div class="form-group">
                        <label for="author_id">Author*</label>
                        <select name="author_id" id="author_id"
                            class="form-control @error('author_id') is-invalid @enderror">
                            <option value="">Select Author</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}"
                                    {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('author_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <!-- Category -->
                    <div class="form-group">
                        <label for="category_id">Category*</label>
                        <select name="category_id" id="category_id"
                            class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="published_at">Published Date</label>
                        <input type="date" name="published_at" id="published_at" class="form-control"
                            value="{{ old('published_at', $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('Y-m-d') : '') }}">
                    </div>

                    <!-- Cover Image -->
                    <div class="form-group">
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
                </div>
            </div>

            <!-- Book PDF -->
            <div class="form-group">
                <label for="file_path">Book File (PDF)</label>
                @if ($book->file_path)
                    <div class="mb-2">
                        <a href="{{ asset('storage/' . $book->file_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            View Current PDF
                        </a>
                    </div>
                @endif
                <input type="file" name="file_path" class="form-control" accept="application/pdf">
                <small class="text-muted">Only PDF files allowed</small>
                @error('file_path')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="form-group text-right">
                <button type="submit" class="btn btn-outline-success">Update Book</button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
