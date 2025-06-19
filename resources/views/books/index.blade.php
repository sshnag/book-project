@extends('adminlte::page')

@section('title', 'Books Management')

@section('content_header')
    <h1>Books Management</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary float-right">
        <i class="fas fa-plus"></i> Add New Book
    </a>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="books-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Published Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will populate this automatically -->
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
    <style>
        #books-table_wrapper .row:first-child,
        #books-table_wrapper .row:last-child {
            padding: 15px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>

    <script>
     $(document).ready(function() {
    $('#books-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.books.index') }}",
            type: "GET",
            data: function(d) {
                // Add any additional parameters here
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX Error:', xhr.responseText);
                $('#books-table').DataTable().clear().draw();
                alert('Failed to load data. Check console for details.');
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            {
                data: 'author_name',
                name: 'author.name',
                render: function(data) {
                    return data || 'N/A';
                }
            },
            {
                data: 'category_name',
                name: 'category.name',
                render: function(data) {
                    return data || 'N/A';
                }
            },
            {
                data: 'published_at',
                name: 'published_at',
                render: function(data) {
                    return data || 'N/A';
                }
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ],
        order: [[0, 'asc']],
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
            emptyTable: 'No books found',
            error: 'Error loading data'
        }
    });
});

    </script>
@stop

@section('plugins.Datatables', true)
