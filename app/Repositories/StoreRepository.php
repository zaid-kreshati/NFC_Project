<?php

namespace App\Repositories;

use App\Models\Store;

class StoreRepository
{
    public function findById(int $id)
    {
        return Store::findOrFail($id);
    }
}
