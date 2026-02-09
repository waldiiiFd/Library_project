<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // Mapear los tipos de usuario a scopes apropiados
        $scopes = $this->getUserScopes();

        return [
            'scopes' => $scopes,
            'user_type' => $this->type,
            'user_code' => $this->code,
            'active' => $this->active,
            'aud' => 'api_v1',
        ];
    }

    /**
     * Obtener los scopes basados en el tipo de usuario
     *
     * @return array
     */
    public function getUserScopes(): array
    {
        // Definir scopes según el tipo de usuario
        $scopeMap = [
            'admin' => [
                'author:read',
                'author:write',
                'book:read',
                'book:write',
                'user:read',
                'user:write',
                'loan:read',
                'loan:write',
                'report:read',
            ],
            'docente' => [
                'author:read',
                'book:read',
                'loan:read',
                'reservation:read',
                'reservation:write',
            ],
            'estudiante' => [
                'author:read',
                'book:read',
                'loan:read',
                'reservation:read',
                'reservation:write',
            ],
            'externo' => [
                'author:read',
                'book:read',
            ],
        ];

        return $scopeMap[$this->type] ?? ['author:read'];
    }

    /**
     * Verificar si el usuario tiene un scope específico
     *
     * @param string $scope
     * @return bool
     */
    public function hasScope(string $scope): bool
    {
        $userScopes = $this->getUserScopes();
        
        // Verificar scope exacto
        if (in_array($scope, $userScopes)) {
            return true;
        }

        // Verificar wildcards (ej: author:* cubre author:read y author:write)
        foreach ($userScopes as $userScope) {
            if (str_ends_with($userScope, ':*')) {
                $prefix = substr($userScope, 0, -1); // Remover el *
                if (str_starts_with($scope, $prefix)) {
                    return true;
                }
            }
        }

        return false;
    }

    // Relaciones
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

    // Reglas de validación
    public static function rules()
    {
        return [
            'code' => 'required|string|max:20|unique:users',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users',
            'type' => 'required|string|in:admin,docente,estudiante,externo',
            'active' => 'boolean',
            'registration_date' => 'date',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public static function updateRules($id)
    {
        return [
            'code' => 'required|string|max:20|unique:users,code,' . $id,
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'type' => 'required|string|in:admin,docente,estudiante,externo',
            'active' => 'boolean',
            'registration_date' => 'date',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    // Scope para filtrar solo usuarios activos
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    // Scope para filtrar por tipo de usuario
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}