<?php

namespace App\Models;
use Ronu\RestGenericClass\Core\Models\BaseModel;

class Author extends BaseModel
{

    protected $fillable = [
        'name',
        'nacionality',
        'birth_date',
    ];
    const MODEL = 'author';
    const RELATIONS = ['books'];

    public function books()
    {
        return $this->belongsToMany(Book::class)
            ->withTimestamps();
    }
}