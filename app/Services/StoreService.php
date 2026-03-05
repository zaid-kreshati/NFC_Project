<?php

namespace App\Services;

use App\Models\Store;
use App\Repositories\StoreRepository;

class StoreService
{
    public function __construct(private StoreRepository $repo) {}

    public function findById(int $id)
    {
        return $this->repo->findById($id);
    }
}
