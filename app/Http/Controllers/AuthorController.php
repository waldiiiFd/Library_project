<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Services\AuthorService;
use Ronu\RestGenericClass\Core\Controllers\RestController;

class AuthorController extends RestController
{


    public function __construct(AuthorService $service)
    {
        $this->modelClass = Author::class;
        $this->service = $service;
    }
}
