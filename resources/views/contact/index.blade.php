@extends('adminlte::page')

@section('title', 'Contact Messages')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold text-dark">Contact Messages</h1>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th style="width: 120px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->id }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ Str::limit($contact->message, 50) }}</td>

                                <td>
                                    <form action="{{ route('admin.contacts.updateStatus', $contact->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()"
                                            class="form-select form-select-sm">
                                            <option value="new" {{ $contact->status == 'new' ? 'selected' : '' }}>New
                                            </option>
                                            <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Read
                                            </option>
                                            <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>
                                                Replied</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}"
                                        class="btn btn-sm btn-outline-info me-1">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this contact message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No contact messages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $contacts->links() }}
        </div>
    </div>
@endsection
