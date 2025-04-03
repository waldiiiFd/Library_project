<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;

class ReservationController extends BaseController
{

    public function __construct(ReservationService $reservationService)
    {
        parent::__construct($reservationService);
    }
}
