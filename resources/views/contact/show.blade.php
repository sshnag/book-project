@extends('adminlte::page')

@section('title', 'Contact Details')

@section('content_header')
    <h1 class="fw-bold text-dark">Contact Message Details</h1>
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5><strong>Name:</strong> {{ $contact->name }}</h5>
            <h5><strong>Email:</strong> {{ $contact->email }}</h5>
            <h5><strong>Book Title:</strong> {{ $contact->book_title ?? 'N/A' }}</h5>
            <h5><strong>Status:</strong>
                <span class="badge
                    @if($contact->status == 'new') bg-warning
                    @elseif($contact->status == 'read') bg-info
                    @elseif($contact->status == 'replied') bg-success
                    @endif">
                    {{ ucfirst($contact->status) }}
                </span>
            </h5>
            <hr>
            <h5><strong>Message:</strong></h5>
            <p>{{ $contact->message }}</p>
        </div>
    </div>

    <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-dark mt-3">
        <i class="fas fa-arrow-left"></i> Back to Contact List
    </a>
@endsection
