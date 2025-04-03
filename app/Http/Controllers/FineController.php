<?php

namespace App\Http\Controllers;

use App\Services\FineService;

class FineController extends BaseController {

    public function __construct(FineService $fineService)
    {
        parent::__construct($fineService);
    }


}
