<?php

namespace App\Http\Controllers;

use App\Services\BookService;

class BookController extends BaseController {

    public function __construct(BookService $bookService)
    {
        parent::__construct($bookService);
    }


}
