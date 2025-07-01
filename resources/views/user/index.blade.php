@extends('adminlte::page')

@section('title', 'Users List')
@section('content_header')

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold text-dark"> Books List</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-outline-dark font-weight-bold" style="border-radius: 50px;">
            <i class="fas fa-plus"></i> Add New User
        </a>
    </div>
@endsection
@include('sweetalert::alert')
@section('content')
    <div class="card shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            @can('manage users')
                                <th>Role</th>
                                <th style="width: 120px">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->name ?? 'N/A' }}</td>
                                <td>{{ $user->email ?? 'N/A' }}</td>
                                <td>
                                    {{ implode(', ', $user->getRoleNames()->toArray()) }}
                                    <br>

                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No users found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white">
            {{ $users->links() }}
        </div>
    </div>
@endsection
{{-- <button onclick="Swal.fire('Hello!', 'It works!', 'success')">Test Alert</button> --}}

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SweetAlert flash success --}}
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

    {{-- SweetAlert confirm delete --}}
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This user will be archieved!',
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
        });
    </script>
@endsection
