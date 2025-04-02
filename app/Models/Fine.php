<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    /** @use HasFactory<\Database\Factories\FineFactory> */
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'amount',
        'reason',
        'generation_date',
        'payment_date',
    ];

    protected $casts = [
        'generation_date' => 'date',
        'payment_date' => 'date',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function rules()
    {
        return [
            'loan_id' => 'required|exists:loans,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:20',
            'generation_date' => 'required|date',
            'payment_date' => 'nullable|date',
        ];
    }


}
