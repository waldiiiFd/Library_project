<?php

namespace App\Services;

use App\Models\Author;
use Ronu\RestGenericClass\Core\Services\BaseService;

class AuthorService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Author::class);
    }
}