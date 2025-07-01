<div class="btn-group" role="group">
    <!-- Edit Button -->

@include('sweetalert::alert')
 @can('delete')

    <!-- Delete Button -->
    <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-outline-danger ml-1">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>

 @endcan
</div>
