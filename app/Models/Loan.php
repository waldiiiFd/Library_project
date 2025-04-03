<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'expected_return_date',
        'return_date',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function books()
    {
        return $this->belongsTo(Book::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }


    public static function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'expected_return_date' => 'required|date|after_or_equal:loan_date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
            'status' => 'required|string',
        ];
    }
}
