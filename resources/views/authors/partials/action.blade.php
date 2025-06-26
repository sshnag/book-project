<div class="btn-group" role="group">
    <!-- Edit Button -->


    <!-- Delete Button -->
    <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger ml-1"
            onclick="return confirm('Are you sure you want to delete this author?')" title="Delete Author">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</div>
