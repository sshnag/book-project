@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Welcome to Blog')

@section('auth_body')
    <div class="text-center">
        <a href="{{ route('login') }}" class="btn btn-outline-dark mb-2 w-100">Login</a>
        <a href="{{ route('register') }}" class="btn btn-dark w-100">Register</a>
    </div>
@endsection
