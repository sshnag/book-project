<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Weekly Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { color: #d63384; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; font-size: 14px; }
    </style>
</head>
<body>
    <h1>Weekly Bookstore Report</h1>
    <p><strong>Total Downloads:</strong> {{ $totalDownloads }}</p>

    <h2>New Books This Week</h2>
    <table>
        <thead>
            <tr><th>Title</th><th>Author</th><th>Published At</th></tr>
        </thead>
        <tbody>
            @forelse ($newBooks as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name ?? 'Unknown' }}</td>
<td>{{ $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('Y-m-d') : 'N/A' }}</td>
                </tr>
            @empty
                <tr><td colspan="3">No new books</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Top 5 Downloaded Books</h2>
    <table>
        <thead>
            <tr><th>Title</th><th>Downloads</th></tr>
        </thead>
        <tbody>
            @foreach ($topDownloads as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->download_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
