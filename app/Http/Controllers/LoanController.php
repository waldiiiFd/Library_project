<?php

namespace App\Http\Controllers;

use App\Services\LoanService;

class LoanController extends BaseController {

    public function __construct(LoanService $loanService)
    {
        parent::__construct($loanService);
    }


}
