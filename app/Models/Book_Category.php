<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_Category extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $table = 'book_category';

    protected $fillable = [
        'book_id',
        'category_id'
    ];

    public function books()
    {
        return $this->belongsTo(Book::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public static function rules()
    {
        return [
            'book_id' => 'required|exists:books,id',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
