<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use App\Services\Publisher\PublisherService;

class PublisherController extends Controller
{
    private PublisherService $publisherService;

    public function __construct(PublisherService $publisherService)
    {
        $this->publisherService = $publisherService;
    }

    public function index()
    {
        return $this->publisherService->listPubishers();
    }

    public function show(Publisher $publisher)
    {
        return $this->publisherService->getPublisher($publisher);
    }

    public function save(?Publisher $publisher = null)
    {
        return $this->publisherService->save($publisher);
    }

    public function destroy(Publisher $publisher)
    {
        return $this->publisherService->destroy($publisher);
    }
}
