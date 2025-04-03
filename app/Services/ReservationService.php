<?php

namespace App\Services;

use App\Models\Reservation;

class ReservationService extends BaseService {
     /**
     * The model class associated with this service
     *
     * @var string
     */
    protected $modelClass = Reservation::class;
}
