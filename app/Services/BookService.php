<?php
namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookService
{
    /**
     * Handle file uploads for book covers and PDF files.
     *
     * @author - SSA
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Book|null $book
     * @return array
     */                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
    public function handleFileUploads($request, Book $book = null): array
    {
        $data = [];

        // Process cover image
        if ($request->hasFile('cover_image')) {
            $this->deleteExistingFile($book?->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        // Process book file
        if ($request->hasFile('file_path')) {
            $this->deleteExistingFile($book?->file_path);
            $data['file_path'] = $request->file('file_path')->store('books', 'public');
        }

        return $data;
    }

    /**
     * Delete existing file from storage if it exists.
     *
     * @author - SSA
     * @param string|null $filePath
     */
    protected function deleteExistingFile(?string $filePath): void
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }

    /**
     * Increment download count for a book.
     *
     * @author - SSA
     * @param \App\Models\Book $book
     * @return \App\Models\Book
     */

    public function incrementDownload(Book $book): Book
    {
        $book->increment('download_count');
        return $book;
    }
}
