@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="animate__animated animate__fadeInDown">Welcome, {{ Auth::user()->name }}!</h1>
@endsection

@section('content')
    <div class="card animate__animated animate__fadeInUp">
        <div class="card-body text-center">
            <p class="text-muted mb-4">You are now logged in</p>
            <a href="{{ route('logout') }}"
               class="btn btn-outline-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
               Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
@endsection

