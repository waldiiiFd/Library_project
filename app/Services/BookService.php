<?php

namespace App\Services;

use App\Models\Book;

class BookService extends BaseService {
     /**
     * The model class associated with this service
     *
     * @var string
     */
    protected $modelClass = Book::class;
}
