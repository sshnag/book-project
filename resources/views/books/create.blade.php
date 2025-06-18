@extends('adminlte::page' )
@section('content')
    <div class="container book-form">
        <h2 class="mb-4">{{ isset($book) ? 'Edit' : 'Add' }} Book</h2>

        <form action="{{ isset($book) ? route('admin.books.update', $book->id) : route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title*</label>
                        <input type="text" name="title" id="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $book->title ?? '') }}" >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description*</label>
                        <textarea name="description" id="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3" >{{ old('description', $book->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="author_id">Author*</label>
                        <select name="author_id" id="author_id"
                                class="form-control @error('author_id') is-invalid @enderror" >
                            <option value="">Select Author</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}"
                                    {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('author_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_id">Category*</label>
                        <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror" >
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>
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
                        <input type="date" name="published_at" id="published_at"
                               class="form-control"
                               value="{{ old('published_at', optional($book->published_at ?? null)->format('Y-m-d')) }}">
                    </div>
                    <div class="form-group">
                        <label for="cover_image">Cover Image</label>
                        <input type="file" name="cover_image" id="cover_image"
                               class="form-control-file" accept="image/jpeg,image/png,image/jpg">
                        @if(isset($book) && $book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}"
                                 class="preview-image" alt="Current Cover">
                            <div class="form-check mt-2">
                                <input class="form-check-input remove-checkbox" type="checkbox"
                                       name="remove_cover" id="remove_cover">
                                <label class="form-check-label" for="remove_cover">Remove current image</label>
                            </div>
                        @endif
                        @error('cover_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

             <div class="form-group">
        <label>Book File (PDF)</label>
        <input type="file" name="file_path" class="form-control" accept=".pdf">
        <small class="text-muted">Only PDF files accepted (Max 10MB)</small>
        @error('file_path')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

            <div class="form-group text-right">
                <button type="submit" class="btn btn-outline-dark">
                    {{ isset($book) ? 'Update' : 'Save' }} Book
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@section('styles')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection
