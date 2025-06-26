<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',

    ];
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function scopePopular($query)
    {
        return $query->where('book_count', '>', 10);
    }}
