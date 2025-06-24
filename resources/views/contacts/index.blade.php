@extends('adminlte::page')

@section('title', 'Contact Messages')

@section('content_header')
    <h1 class="fw-bold text-dark">Contact Messages</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <table id="contact-table" class="table table-hover w-100">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Book Title</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Sent At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .badge {
            font-size: 0.9em;
            padding: 0.5em 0.75em;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#contact-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.contact.data') }}",
                columns: [
                    { data: 'id', name: 'id', className: 'align-middle' },
                    { data: 'name', name: 'name', className: 'align-middle' },
                    { data: 'email', name: 'email', className: 'align-middle' },
                    { data: 'book_title', name: 'book_title', className: 'align-middle' },
                    { data: 'message', name: 'message', className: 'align-middle' },
                    { data: 'status', name: 'status', className: 'align-middle text-center' },
                    { data: 'created_at', name: 'created_at', className: 'align-middle' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[0, 'desc']],
                responsive: true
            });
        });
    </script>
@endpush
