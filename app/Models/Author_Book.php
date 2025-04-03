<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author_Book extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    protected $table = 'author_book';

    protected $fillable = [
        'author_id',
        'book_id'
    ];

    public function authors()
    {
        return $this->belongsTo(Author::class);
    }

    public function books()
    {
        return $this->belongsTo(Book::class);
    }

    public static function rules()
    {
        return [
            'author_id' => 'required|exists:authors,id',
            'book_id' => 'required|exists:books,id'
        ];
    }
}
