<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\FirmRepositoryInterface;

class UserService
{
    protected UserRepositoryInterface $userRepository;
    protected FirmRepositoryInterface $firmRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        FirmRepositoryInterface $firmRepository
    ) {
        $this->userRepository = $userRepository;
        $this->firmRepository = $firmRepository;
    }

    public function createUser(array $data)
    {

        if (User::where('email', $data['email'])->exists()) {
            return ['error' => 'Bu email zaten kayıtlı'];
        }

        if (isset($data['firm_name'])) {
            $firm = $this->findOrCreateFirm($data['firm_name']);
            $data['firm_id'] = $firm->id;
            unset($data['firm_name']);
        }

        return $this->userRepository->create($data);
    }

    public function getUsers(array $filters)
    {
        return $this->userRepository->getAll($filters);
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->findById($id);
    }

    public function updateUser(int $id, array $data)
    {
        $user = $this->userRepository->findById($id);


        if (isset($data['email']) && $data['email'] !== $user->email) {
            if (User::where('email', $data['email'])->where('id', '!=', $id)->exists()) {
                return ['error' => 'Bu email başka kullanıcıda kayıtlı'];
            }
        }

        if (isset($data['firm_name'])) {
            $firm = $this->findOrCreateFirm($data['firm_name']);
            $data['firm_id'] = $firm->id;
            unset($data['firm_name']);
        }

        return $this->userRepository->update($user, $data);
    }

    public function deleteUser(int $id)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return ['error' => 'Kullanıcı bulunamadı'];
        }

        $deleted = $this->userRepository->delete($user);

        if (!$deleted) {
            return ['error' => 'Kullanıcı silinemedi'];
        }

        return true;
    }

    private function findOrCreateFirm(string $firmName)
    {
        $firms = $this->firmRepository->getAll();
        $firm = $firms->firstWhere('name', $firmName);

        if (!$firm) {
            $firm = $this->firmRepository->create(['name' => $firmName]);
        }

        return $firm;
    }
}
