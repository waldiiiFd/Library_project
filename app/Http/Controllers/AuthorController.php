<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;

class AuthorController extends BaseController {

    public function __construct(AuthorService $authorService)
    {
        parent::__construct($authorService);
    }
}
