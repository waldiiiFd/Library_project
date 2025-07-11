<?php

namespace App\Http\Controllers;

use App\Services\ViewStatisticsService;

class ViewStatisticsController extends BaseController {

    public function __construct(ViewStatisticsService $viewStatisticsService)
    {
        parent::__construct($viewStatisticsService);
    }
}
