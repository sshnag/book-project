@php
    // Verify routes exist before using them
    $viewRoute = route('admin.contacts.show', $contact);
    $deleteRoute = route('admin.contacts.destroy', $contact);
@endphp

<div class="d-flex justify-content-center gap-1">
    <a href="{{ $viewRoute }}" class="btn btn-sm btn-primary" title="View Message">
        <i class="fas fa-eye"></i>
    </a>

    <form action="{{ $deleteRoute }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" title="Delete Message"
                onclick="return confirm('Are you sure you want to delete this message?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>
