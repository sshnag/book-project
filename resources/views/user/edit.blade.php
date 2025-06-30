@extends('adminlte::page')

@section('title', 'Edit User Role & Permissions')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">

    <h1 class="fw-bold text-dark">Edit Role & Permissions for {{ $user->name }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark font-weight-bold" >
          Back
        </a>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <x-adminlte-alert theme="success" dismissable>
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        {{-- Role Selection --}}
        <div class="mb-4">
            <label for="role" class="form-label fw-bold">Select Role</label>
            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                <option disabled>Assign Role</option>
                @foreach ($roles as $role)
                    @if ($role->name !== 'superadmin')
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endif
                @endforeach
            </select>

            @error('role')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- Permissions Checkboxes --}}
        @php
            $isUserRole = $user->hasRole('user');
        @endphp

        <div class="mb-4">
            <label class="form-label fw-bold">Permissions</label>
            <div class="row">
                @foreach ($permissions as $permission)
                    <div class="col-md-4">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="permissions[]"
                                id="perm_{{ $permission->id }}"
                                value="{{ $permission->name }}"
                                {{ in_array($permission->name, old('permissions', $user->getPermissionNames()->toArray())) ? 'checked' : '' }}
                                {{ $isUserRole ? 'disabled' : '' }}
                            >
                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            @error('permissions')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit Buttons --}}
        <button type="submit" class="btn btn-dark me-2" {{ $isUserRole ? 'disabled' : '' }}>Update User</button>
    </form>
@endsection
