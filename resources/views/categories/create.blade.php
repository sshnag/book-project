@extends('adminlte::page')

@section('content')
    <div class="container mx-auto max-w-lg mt-8 p-6 bg-white rounded-lg shadow-md">

                    </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <strong>Whoops!</strong> Please fix the following errors:<br><br>
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="form-group">
                                    <div class="d-flex justify-content-between align-items-center">

                <label for="name" class="block mb-2 text-gray-700 font-medium">Category Name</label>
                 <a href="javascript:void(0)" onclick="history.back()"
                    class="btn btn-secondary px-6 py-2 rounded-md font-semibold text-gray-700 border border-gray-300 hover:bg-gray-100 transition text-center">
                    Back
                </a>
                                    </div>

                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline focus:ring-2  "
                    placeholder="Enter category name">
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="btn btn-outline-dark">
                    Create Category
                </button>

            </div>
        </form>
    </div>

@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset(path: 'css/book.css') }}">
@endpush
