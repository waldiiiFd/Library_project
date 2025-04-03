<?php

namespace App\Services;

use App\Models\Loan;

class LoanService extends BaseService {
     /**
     * The model class associated with this service
     *
     * @var string
     */
    protected $modelClass = Loan::class;
}
