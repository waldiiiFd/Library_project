<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'email',
        'type',
        'active',
        'registration_date',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'registration_date' => 'date',
            'active' => 'boolean',
        ];
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function search_histories()
    {
        return $this->hasMany(SearchHistory::class);
    }

    public static function rules(){
        return [
            'code' => 'required|string|max:20',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'type' => 'required|string|max:100',
            'active' => 'boolean',
            'registration_date' => 'date',
            'password' => 'required|string|min:8|confirmed',
        ];

    }
}
