<?php

namespace App\Services;

use App\Models\User;

class UserService extends BaseService {
     /**
     * The model class associated with this service
     *
     * @var string
     */
    protected $modelClass = User::class;
}
