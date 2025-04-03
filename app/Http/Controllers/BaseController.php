<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

abstract class BaseController extends Controller
{
    protected $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Listar todos los registros
     */
    public function index(): JsonResponse
    {
        $result = $this->service->index();

        return $result['success']
            ? response()->json([
                'success' => true,
                'data' => $result['data']
            ])
            : response()->json([
                'success' => false,
                'message' => $result['message']
            ], 500);
    }

    /**
     * Mostrar un registro específico
     */
    public function show(string $id): JsonResponse
    {
        $result = $this->service->show($id);

        return $result['success']
            ? response()->json([
                'success' => true,
                'data' => $result['data']
            ])
            : response()->json([
                'success' => false,
                'error' => 'Record not found',
                'message' => $result['message']
            ], 404);
    }

    /**
     * Crear un nuevo registro
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->service->store($request->all());

        return $result['success']
            ? response()->json([
                'success' => true,
                'data' => $result['data']
            ], 201)
            : response()->json([
                'success' => false,
                'errors' => $result['message'],
                'message' => 'Validation error'
            ], 422);
    }

    /**
     * Actualizar un registro
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $result = $this->service->update($id, $request->all());

        return $result['success']
            ? response()->json([
                'success' => true,
                'data' => $result['data']
            ])
            : response()->json([
                'success' => false,
                'error' => 'Record not found',
                'message' => $result['message']
            ], 422);
    }

    /**
     * Eliminar un registro
     */
    public function destroy(string $id): JsonResponse
    {
        $result = $this->service->destroy($id);

        return $result['success']
            ? response()->json([
                'success' => true,
            ])
            : response()->json([
                'success' => false,
                'error' => 'Record not found',
                'message' => $result['message']
            ], 404);
    }
}
