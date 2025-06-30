@extends('adminlte::page')

@section('title', 'Users List')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold text-dark"> Users List</h1>

</div>@endsection

{{-- @section('css')
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endsection --}}

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                                    @can('assign roles')
                                        <form action="{{ route('admin.users.assignRole', $user->id) }}" method="post"
                                            class="d-inline me-1">
                                            @csrf
                                            <select name="role" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option disabled>Assign Role</option>
                                                @foreach (['user', 'bookadmin'] as $role)
                                                    <option value="{{ $role }}"
                                                        {{ $user->hasRole($role) ? 'selected' : '' }}>
                                                        {{ ucfirst($role) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @endcan
                                </td>
                                @can('manage users')
                                    <td>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No users found.</td>
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
