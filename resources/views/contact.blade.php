@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="container my-5">
  <div class="row">
    <!-- Contact Form in Card Style -->
    <div class="col-md-6 mb-4">
      <div class="card custom-card border-0 shadow">
        <div class="card-body p-4">
          <h3 class="card-title mb-3 text-dark">Contact Us</h3>
          <p class="text-muted">We’d love to hear from you! Fill out the form below and we'll get back to you soon.</p>

          @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="you@example.com">
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="mb-3">
              <label for="book_title" class="form-label">Book Title (optional)</label>
              <input type="text" name="book_title" class="form-control" value="{{ old('book_title') }}" placeholder="Book Title">
            </div>

            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea name="message" class="form-control" rows="4" placeholder="Write your message">{{ old('message') }}</textarea>
              @error('message')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <button type="submit" class="btn btn-outline-dark">Send</button>
            <button type="reset" class="btn btn-pink ms-2">Clear</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Contact Info Over Image -->
    <div class="col-md-6">
      <div class="position-relative overflow-hidden rounded shadow">
        <img src="{{ asset('images/hero1.jpg') }}" alt="Contact Us" class="img-fluid w-100" style="object-fit: cover; min-height: 525px;">

        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-start text-white p-4" style="background-color: rgba(0, 0, 0, 0.5);">
          <p><strong>Email</strong><br>bookie@gmail.com</p>
          <p><strong>Location</strong><br>Yangon</p>
          <p><strong>Follow us on</strong><br>
            <div id="socialmedia-links">
              <a href="#"><i class="fab fa-facebook me-3 text-white"></i></a>
              <a href="#"><i class="fab fa-linkedin me-3 text-white"></i></a>
              <a href="#"><i class="fab fa-youtube me-3 text-white"></i></a>
              <a href="#"><i class="fab fa-instagram text-white"></i></a>
            </div>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
