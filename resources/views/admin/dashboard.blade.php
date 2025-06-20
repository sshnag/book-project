@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Admin Dashboard</h1>
@stop
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


@section('content')
<div class="row">
  <div class="col-md-6">
    <canvas id="barChart"></canvas>
  </div>
  <div class="col-md-6">
    <canvas id="pieChart"></canvas>
  </div>
</div>

<script>
  const barCtx = document.getElementById('barChart').getContext('2d');
  const pieCtx = document.getElementById('pieChart').getContext('2d');

  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: ['Books', 'Authors', 'Categories'],
      datasets: [{
        label: 'Counts',
        data: [{{ $bookCount }}, {{ $authorCount }}, {{ $categoryCount }}],
        backgroundColor: ['#3498db', '#e67e22', '#2ecc71']
      }]
    }
  });

  new Chart(pieCtx, {
    type: 'pie',
    data: {
      labels: ['Books', 'Authors', 'Categories'],
      datasets: [{
        data: [{{ $bookCount }}, {{ $authorCount }}, {{ $categoryCount }}],
        backgroundColor: ['#3498db', '#e67e22', '#2ecc71']
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
            {{ $books->links() }} <!-- Pagination links -->
        </div>
    </div>
@stop
