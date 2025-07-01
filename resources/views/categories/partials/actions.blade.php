
@can('delete')

<form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-outline-danger">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>

@endcan
