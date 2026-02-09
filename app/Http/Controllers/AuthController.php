<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Login de usuario y generación de JWT
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Verificar que el usuario existe y está activo
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        if (!$user->active) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario inactivo. Contacte al administrador.'
            ], 403);
        }

        // Intentar autenticar al usuario
        $token = Auth::guard('api')->attempt($credentials);
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        return $this->respondWithToken($token, $user);
    }

    /**
     * Register de nuevo usuario
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'code' => $request->code,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'type' => $request->type,
            'active' => true,
            'registration_date' => now(),
        ]);

        // Generar token automáticamente después del registro
        $token = Auth::guard('api')->login($user);

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado exitosamente',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ], 201);
    }

    /**
     * Obtener información del usuario autenticado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        /** @var User|null $user */
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No autenticado'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => $user,
            'scopes' => $user->getUserScopes(),
        ]);
    }

    /**
     * Logout del usuario (invalidar token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }

    /**
     * Refrescar el token JWT
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            
            /** @var User|null $user */
            $user = Auth::guard('api')->user();

            return $this->respondWithToken($newToken, $user);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo refrescar el token'
            ], 401);
        }
    }

    /**
     * Respuesta con token y datos del usuario
     *
     * @param string $token
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user = null)
    {
        if (!$user) {
            /** @var User|null $user */
            $user = Auth::guard('api')->user();
        }

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => [
                'id' => $user->id,
                'code' => $user->code,
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user->type,
                'active' => $user->active,
                'scopes' => $user->getUserScopes(),
            ]
        ]);
    }
}