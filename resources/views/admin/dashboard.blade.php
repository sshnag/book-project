@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')

    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-dark fw-bold">Admin Dashboard</h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dashboardDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-book me-1"></i> <span>Add New</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="dashboardDropdown">
                <a class="dropdown-item py-2" href="{{ route('admin.authors.create') }}">
                    <i class="fas fa-feather me-2 text-info"></i> Authors
                </a>
                <a class="dropdown-item py-2" href="{{ route('admin.categories.create') }}">
                    <i class="fas fa-tags me-2 text-success"></i> Categories
                </a>
                <a class="dropdown-item py-2" href="{{ route('admin.books.create') }}">
                    <i class="fas fa-book me-2 text-primary"></i> Books
                </a>

            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row mb-4">
        <!-- Bar Chart Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">Downloads per Category</h5>
                    <canvas id="downloadChart" style="min-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart Card -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3 fw-semibold">Book Stats</h5>
                    <canvas id="pieChart" style="min-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Books Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">Recent Books</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
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
                                    class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">No books found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $books->links() }}
        </div>
    </div>
@stop


@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js/dist/Chart.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const downloadCtx = document.getElementById('downloadChart').getContext('2d');
        const pieCtx = document.getElementById('pieChart').getContext('2d');

        // Bar Chart
        new Chart(downloadCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Downloads',
                    data: {!! json_encode($downloads) !!},
                    backgroundColor: '#92C5F9',
                    borderRadius: 6,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 10
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#eee'
                        },
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            },
                            precision: 0
                        }
                    }
                }
            }
        });

        // Pie/Doughnut Chart
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Books', 'Authors', 'Categories'],
                datasets: [{
                    data: [{{ $bookCount }}, {{ $authorCount }}, {{ $categoryCount }}],
                    backgroundColor: ['#17BECF', '#FFC20A', '#00668E'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#333',
                            font: {
                                size: 13,
                                weight: 'bold'
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1F2937',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        }
                    }
                }
            }
        });
    </script>
@endpush
