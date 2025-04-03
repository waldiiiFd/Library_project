<?php

namespace App\Http\Controllers;

use App\Services\PublisherService;

class PublisherController extends BaseController {

    public function __construct(PublisherService $publisherService)
    {
        parent::__construct($publisherService);
    }


}
