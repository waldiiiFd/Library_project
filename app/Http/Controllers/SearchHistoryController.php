<?php

namespace App\Http\Controllers;

use App\Services\SearchHistoryService;

class SearchHistoryController extends BaseController
{
    public function __construct(SearchHistoryService $searchHistoryService)
    {
        parent::__construct($searchHistoryService);
    }
}
