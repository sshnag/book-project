<div class="d-flex justify-content-center">
    {{-- Edit Button --}}
    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-outline-primary me-2">
        <i class="fas fa-edit"></i>
    </a>
    {{-- Delete Button --}}
    @can('delete')

    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
    @endcan

</div>
