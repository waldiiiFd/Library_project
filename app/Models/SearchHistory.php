<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory  extends Model
{
    /** @use HasFactory<\Database\Factories\SearchHistoryFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'search_term'
    ];

    protected $casts = [
        'searched_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'search_term' => 'required|string|max:100',
            'searched_at' => 'nullable|date',
        ];
    }
}
