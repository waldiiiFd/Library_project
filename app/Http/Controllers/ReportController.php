<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Obtener los libros más populares (con más préstamos) en el último mes
     *
     * @return JsonResponse
     */
    public function popularBooks(): JsonResponse
    {
        $result = $this->reportService->getPopularBooks();

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
