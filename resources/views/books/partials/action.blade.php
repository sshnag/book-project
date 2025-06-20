<div class="btn-group">
    <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-info btn-sm">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this book?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
