@extends('adminlte::page')

@section('title', 'View Contact Message')

@section('content_header')
    <h1 class="fw-bold text-dark">Contact Message Details</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $contact->name }}</p>
                    <p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                    <p><strong>Book Title:</strong> {{ $contact->book_title ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong>
                        @php
                            $badgeColor = match ($contact->status) {
                                'new' => 'warning',
                                'read' => 'info',
                                'replied' => 'success',
                                default => 'secondary',
                            };
                        @endphp
                        <span class="badge bg-{{ $badgeColor }}">{{ ucfirst($contact->status) }}</span>
                    </p>
                    <p><strong>Received At:</strong> {{ $contact->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            <hr>

            <div class="mt-4">
                <h5>Message:</h5>
                <div class="border p-3 rounded bg-light">
                    {{ $contact->message }}
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>

            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline float-end">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash me-1"></i> Delete Message
                </button>
            </form>
        </div>
    </div>
@stop
