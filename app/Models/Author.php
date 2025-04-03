<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'nacionality',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->withTimestamps();
    }


    public static function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'nacionality' => 'required|string|max:50',
            'birth_date' => 'nullable|date',
        ];
    }
}
