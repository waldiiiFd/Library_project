<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    /** @use HasFactory<\Database\Factories\PublisherFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'publisher_id');
    }

    public static function rules(){
        return [
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:100',
        ];
    }
}
