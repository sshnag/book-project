<a href="{{ route('books.show', $row->id) }}" class="btn btn-sm btn-info">View</a>
<a href="{{ route('books.edit', $row->id) }}" class="btn btn-sm btn-warning">Edit</a>

<form method="POST" action="{{ route('books.destroy', $row->id) }}" >
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
</form>
