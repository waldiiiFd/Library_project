<?php

namespace App\Http\Controllers;

use App\Services\AuthorBookService;

class AuthorBookController extends BaseController {

    public function __construct(AuthorBookService $author_bookService)
    {
        parent::__construct($author_bookService);
    }
}
