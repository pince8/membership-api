<?php

namespace App\Repositories;

use App\Models\Firm;
use App\Repositories\Interfaces\FirmRepositoryInterface;

class FirmRepository implements FirmRepositoryInterface
{

    public function create(array $data): Firm
    {
        return Firm::create($data);
    }
    public function getAll()
    {
        return Firm::all();
    }

    public function findById(int $id): Firm
    {
        return Firm::findOrFail($id);
    }
}
