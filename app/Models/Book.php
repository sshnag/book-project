<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
        protected $dates = ['published_at'];



   protected $fillable = [
    'title',
    'description',
    'author_id',
    'category_id',
    'published_at',
    'cover_image',
    'file_path',
];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
