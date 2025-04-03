<?php

namespace App\Services;

use Throwable;
use Illuminate\Support\Facades\Validator;

abstract class BaseService
{
    /**
     * Model class to be used by the service
     *
     * @var string
     */
    protected $modelClass;

    /**
     * Validate data using the model's rules
     *
     * @param array $data
     * @return array
     */
    protected function validateData(array $data): array
    {
        $modelClass = $this->modelClass;
        $validator = Validator::make($data, $modelClass::rules());

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()->first()
            ];
        }

        return ['success' => true];
    }

    /**
     * Get all records
     *
     * @return array
     */
    public function index(): array
    {
        try {
            $modelClass = $this->modelClass;

            /*  $query = $modelClass::query();
            $records = $query->get(); */
            $records = $modelClass::all();

            return [
                'success' => true,
                'data' => $records
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error al recuperar los registros: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Find a record by ID
     *
     * @param string $id
     * @return array
     */
    public function show(string $id): array
    {
        try {
            $modelClass = $this->modelClass;

            /* $query = $modelClass::query();
            $record = $query->findOrFail($id); */
            $record = $modelClass::findOrFail($id);

            return [
                'success' => true,
                'data' => $record
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Registro no encontrado: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return array
     */
    public function store(array $data): array
    {
        $validationResult = $this->validateData($data);
        if (!$validationResult['success']) {
            return $validationResult;
        }

        try {
            $modelClass = $this->modelClass;
            $record = $modelClass::create($data);

            return [
                'success' => true,
                'data' => $record
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error al crear el registro: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update an existing record
     *
     * @param string $id
     * @param array $data
     * @return array
     */
    public function update(string $id, array $data): array
    {
        try {
            $modelClass = $this->modelClass;
            $record = $modelClass::findOrFail($id);

            $validationResult = $this->validateData($data);
            if (!$validationResult['success']) {
                return $validationResult;
            }

            $updated = $record->update($data);

            if (!$updated) {
                return [
                    'success' => false,
                    'message' => 'No se pudo actualizar el registro'
                ];
            }

            return [
                'success' => true,
                'data' => $record
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error al actualizar el registro: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Delete a record
     *
     * @param string $id
     * @return array
     */
    public function destroy(string $id): array
    {
        try {
            $modelClass = $this->modelClass;
            $record = $modelClass::findOrFail($id);
            $deleted = $record->delete();

            if (!$deleted) {
                return [
                    'success' => false,
                    'message' => 'No se pudo eliminar el registro'
                ];
            }

            return [
                'success' => true,
                'data' => null
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Error al eliminar el registro: ' . $e->getMessage()
            ];
        }
    }
}
