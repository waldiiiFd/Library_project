<?php

namespace App\Http\Controllers;

use App\Services\BookCategoryService;

class BookCategoryController extends BaseController
{

    public function __construct(BookCategoryService $book_categoryService)
    {
        parent::__construct($book_categoryService);
    }
}
