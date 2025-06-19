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
        'uploaded_at',
        'file_path',
        'cover_image'    ];
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
