<?php

namespace App\Services\v1;

use App\Models\User;
use App\Repositories\v1\interfaces\UserRepositoryInterface;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}
    public function all()
    {
        return $this->userRepository->all();
    }
    public function find($userId)
    {
        return $this->userRepository->find($userId);
    }
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }
    public function update($userId, array $data)
    {
        return $this->userRepository->update($userId, $data);
    }
    public function delete($userId)
    {
        return $this->userRepository->delete($userId);
    }

    // Family Specific
    public function getFamilyMembers($parentId)
    {
        return $this->userRepository->getFamilyMembers($parentId);
    }
}
