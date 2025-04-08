<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\ViewStatisticsService;

class ViewStatisticsController extends BaseController {

    public function __construct(ViewStatisticsService $authorService)
    {
        parent::__construct($authorService);
    }
}
