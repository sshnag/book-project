@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold text-dark">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-dark font-weight-bold" style="border-radius: 50px;">
            <i class="fas fa-plus"></i> Add New Category
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <table id="categories-table" class="table table-hover w-100">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th class="text-center">Books</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var table = $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.categories.data') }}",
                columns: [
                    { data: 'name', name: 'name', className: 'align-middle' },
                    {
                        data: 'books_count',
                        name: 'books_count',
                        className: 'text-center align-middle',
                        searchable: false,
                        render: function(data) {
                            return `<span class="badge bg-primary">${data} books</span>`;
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center align-middle' }
                ],
                language: {
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No categories found",
                    info: "Showing _START_ to _END_ of _TOTAL_ categories",
                    infoEmpty: "Showing 0 to 0 of 0 categories",
                    infoFiltered: "(filtered from _MAX_ total categories)",
                    search: "_INPUT_",
                    searchPlaceholder: "Search categories...",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-chevron-right"></i>',
                        previous: '<i class="fas fa-chevron-left"></i>'
                    }
                },
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                drawCallback: function(settings) {
                    $('.delete-form').off('submit').on('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Are you sure?',
                            text: 'This category will be deleted!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#e3342f',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                }
            });
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@endpush
