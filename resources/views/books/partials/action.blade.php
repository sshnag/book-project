<div class="btn-group" role="group" aria-label="Book Actions">
    <!-- View Button -->
    <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-sm btn-info" title="View Details">
        <i class="fas fa-eye"></i>
    </a>

    <!-- Edit Button -->
    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-primary mx-1" title="Edit Book">
        <i class="fas fa-edit"></i>
    </a>

    <!-- Download Button -->
    <a href="{{ route('admin.books.download', $book->id) }}" class="btn btn-sm btn-success mx-1" title="Download Book">
        <i class="fas fa-download"></i>
    </a>

    <!-- Delete Button -->
    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger"
            onclick="return confirm('Are you sure you want to delete this book?')" title="Delete Book">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</div>
