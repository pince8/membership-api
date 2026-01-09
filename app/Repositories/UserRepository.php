<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function getAll(array $filters)
    {
        $query = User::query()->with('firm');

        if (!empty($filters['id'])) {
            $query->where('id', $filters['id']);
        }
        if (!empty($filters['firm_name'])) {
            $query->whereHas('firm', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['firm_name'] . '%');
            });
        }
        if (!empty($filters['first_name'])) {
            $query->where('first_name', 'like', '%' . $filters['first_name'] . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', $filters['email']);
        }

        if (!empty($filters['phone'])) {
            $query->where('phone', $filters['phone']);
        }

        if (!empty($filters['firm_id'])) {
            $query->where('firm_id', $filters['firm_id']);
        }

        return $query->get();
    }
    public function findById(int $id): User
    {
        return User::with('firm')->findOrFail($id);
    }
    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }
    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }
}
