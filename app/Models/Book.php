<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'publisher_id',
        'year_published',
        'edition',
        'stock_total',
        'stock_available',
    ];

    protected $casts = [
        'year_published' => 'integer',
        'edition' => 'integer',
        'stock_total' => 'integer',
        'stock_available' => 'integer',
    ];

    public function publishers()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class)
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->withTimestamps();
    }

    public static function rules()
    {
        return [
            'title' => 'required|string|max:200',
            'isbn' => 'required|string|max:20|unique:books,isbn',
            'publisher_id' => 'required|exists:publishers,id',
            'year_published' => 'required|integer',
            'edition' => 'nullable|integer',
            'stock_total' => 'nullable|integer',
            'stock_available' => 'nullable|integer'
        ];
    }
}
