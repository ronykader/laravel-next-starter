<?php

namespace App\Repositories\v1\interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function find(int $userId);
    public function create(array $data);
    public function update(int $userId, array $data);
    public function delete(int $userId): User;
    public function getFamilyMembers(int $parentId);
}
