@extends('adminlte::page')

@section('title', 'Authors')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold text-dark">Authors</h1>
        <a href="{{ route('admin.authors.create') }}" class="btn btn-outline-dark font-weight-bold" style="border-radius: 50px;">
            <i class="fas fa-plus"></i> Add New Author
        </a>
    </div>
@stop

@section('content')
    {{-- Optional: Remove old Bootstrap alert and rely on SweetAlert --}}
    {{--
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    --}}

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <table id="authors-table" class="table table-hover w-100">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th class="text-center">Books</th>
                        <th>Actions</th>
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
    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Delete confirmation handler function
            function deleteHandler(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This author will be archived!',
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
            }

            // Initialize DataTable
            var table = $('#authors-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.authors.index') }}",
                columns: [
                    { data: 'id', name: 'id', width: '5%', className: 'align-middle' },
                    { data: 'name', name: 'name', className: 'align-middle font-weight-bold' },
                    {
                        data: 'books_count',
                        name: 'books_count',
                        className: 'text-center align-middle',
                        searchable: false,
                        render: function(data) {
                            return `<span class="badge badge-book-count bg-primary">${data} books</span>`;
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center align-middle', width: '15%' }
                ],
                language: {
                    lengthMenu: "Show _MENU_ entries",
                    zeroRecords: "No authors found",
                    info: "Showing _START_ to _END_ of _TOTAL_ authors",
                    infoEmpty: "Showing 0 to 0 of 0 authors",
                    infoFiltered: "(filtered from _MAX_ total authors)",
                    search: "_INPUT_",
                    searchPlaceholder: "Search authors...",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-chevron-right"></i>',
                        previous: '<i class="fas fa-chevron-left"></i>'
                    }
                },
                order: [[0, 'asc']],
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50],
                drawCallback: function(settings) {
                    // Row hover effect
                    $('#authors-table tbody tr').hover(
                        function() { $(this).css('background-color', '#f8f9fa'); },
                        function() { $(this).css('background-color', ''); }
                    );

                    // Attach SweetAlert delete confirmation to delete buttons
                    $('#authors-table .delete-form').off('submit').on('submit', deleteHandler);
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
