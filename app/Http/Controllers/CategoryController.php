<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;

class CategoryController extends BaseController {

    public function __construct(CategoryService $categoryService)
    {
        parent::__construct($categoryService);
    }
}
