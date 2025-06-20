@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Admin Dashboard</h1>
@stop
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


@section('content')
<div class="row">
  <div class="col-md-6">
    <canvas id="downloadChart"></canvas>
  </div>
  <div class="col-md-6">
    <canvas id="pieChart"></canvas>
  </div>
</div>

<script>
  const pieCtx = document.getElementById('pieChart').getContext('2d');

   const downloadCtx = document.getElementById('downloadChart').getContext('2d');
    new Chart(downloadCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
          label: 'Downloads per Category',
          data: {!! json_encode($downloads) !!},
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
        options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          precision: 0 // 👈 disables decimals
        }
      }
    }
  }
});

  new Chart(pieCtx, {
    type: 'pie',
    data: {
      labels: ['Books', 'Authors', 'Categories'],
      datasets: [{
        data: [{{ $bookCount }}, {{ $authorCount }}, {{ $categoryCount }}],
        backgroundColor: ['#17BECF', '#FFC20A', '#00668E']
      }]
    }
  });
</script>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Books</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author->name ?? 'N/A' }}</td>
                            <td>{{ $book->category->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.books.edit', $book->id) }}"
                                   class="btn btn-sm btn-ou">Edit</a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                      style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No books found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <br>
            {{ $books->links() }} <!-- Pagination links -->
        </div>
    </div>
@stop

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
        <link rel="stylesheet" href="{{ asset('css/book.css') }}">

@endpush('css')
