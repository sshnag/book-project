<?
namespace App\Services;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;


class BookService{
public function handleFileUploads($request, Book $book = null)
    {
        $data = [];

        if ($request->hasFile('cover_image')) {
            if ($book && $book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        if ($request->hasFile('file_path')) {
            if ($book && $book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $data['file_path'] = $request->file('file_path')->store('books', 'public');
        }

        return $data;
    }

public function incrementDownload(Book $book)
{
    $book->increment('download_count'
);
return $book;
}
}
