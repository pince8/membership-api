<?php

namespace App\Repositories\Interfaces;

use App\Models\Firm;

interface FirmRepositoryInterface
{
public function create(array $data):Firm;

public function getAll();

public function findById(int $id):Firm;
}
