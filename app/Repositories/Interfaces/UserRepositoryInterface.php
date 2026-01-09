<?php

namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

interface UserRepositoryInterface
{
public function create(array $data): User;

public function getAll(array $filters);

public function findById(int $id): User;

public function update(User $user,array $data):User;

public function delete(User $user):bool;


}
