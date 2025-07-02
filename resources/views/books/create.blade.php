@extends('adminlte::page')

@section('title', 'Add Book')

@section('content')
<div class="container book-form mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Book</h2>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
    </div>

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            {{-- Left Column --}}
            <div class="col-md-6">
                {{-- Title --}}
                <div class="form-group mb-3">
                    <label for="title">Title<span class="text-danger">*</span></label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        required
                    >
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Description --}}
                <div class="form-group mb-3">
                    <label for="description">Description<span class="text-danger">*</span></label>
                    <textarea
                        name="description"
                        id="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        required
                    >{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Author --}}
                <div class="form-group mb-3">
                    <label for="author_id">Author<span class="text-danger">*</span></label>
                    <select
                        name="author_id"
                        id="author_id"
                        class="form-control @error('author_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Select Author</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-md-6">
                {{-- Category --}}
                <div class="form-group mb-3">
                    <label for="category_id">Category<span class="text-danger">*</span></label>
                    <select
                        name="category_id"
                        id="category_id"
                        class="form-control @error('category_id') is-invalid @enderror"
                        required
                    >
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Published Date --}}
                <div class="form-group mb-3">
                    <label for="published_at">Published Date</label>
                    <input
                        type="date"
                        name="published_at"
                        id="published_at"
                        class="form-control"
                        value="{{ old('published_at') }}"
                    >
                </div>

                {{-- Cover Image --}}
                <div class="form-group mb-3">
                    <label for="cover_image">Cover Image</label>
                    <input
                        type="file"
                        name="cover_image"
                        id="cover_image"
                        class="form-control-file @error('cover_image') is-invalid @enderror"
                        accept="image/jpeg,image/png,image/jpg"
                    >
                    @error('cover_image') <div class="text-danger">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- PDF File --}}
        <div class="form-group mb-4">
            <label for="file_path">Book File (PDF)</label>
            <input
                type="file"
                name="file_path"
                id="file_path"
                class="form-control @error('file_path') is-invalid @enderror"
                accept=".pdf"
            >
            <small class="text-muted">Only PDF files accepted (Max 10MB)</small>
            @error('file_path') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Submit --}}
        <div class="text-end">
            <button type="submit" class="btn btn-outline-dark">Save Book</button>
        </div>
    </form>
</div>
@endsection
