<div class="mb-3">
    <label>Title</label>
    <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Description</label>
    <textarea name="description" class="form-control">{{ old('description', $book->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Author</label>
    <select name="author_id" class="form-control">
        @foreach($authors as $author)
            <option value="{{ $author->id }}" {{ (old('author_id', $book->author_id ?? '') == $author->id) ? 'selected' : '' }}>
                {{ $author->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Category</label>
    <select name="category_id" class="form-control">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ (old('category_id', $book->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Published At</label>
    <input type="date" name="published_at" value="{{ old('published_at', optional($book->published_at ?? null)->format('Y-m-d')) }}" class="form-control">
</div>

<div class="mb-3">
    <label>Cover Image</label>
    <input type="file" name="cover_image" class="form-control">
    @if(!empty($book->cover_image))
        <img src="{{ asset('storage/'.$book->cover_image) }}" height="80">
    @endif
</div>

<div class="mb-3">
    <label>Book File (PDF)</label>
    <input type="file" name="file_path" class="form-control">
    @if(!empty($book->file_path))
        <a href="{{ asset('storage/'.$book->file_path) }}" target="_blank">Current File</a>
    @endif
</div>
