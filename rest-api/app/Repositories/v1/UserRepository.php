<?php

namespace App\Repositories\v1;

use App\Models\User;
use App\Repositories\v1\interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly User $model)
    {
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function find(int $userId)
    {
        return $this->model
            ->where('id', $userId)
            ->where('parent_id', Auth::id())
            ->firstOrFail();
    }

    public function update(int $userId, array $data)
    {
        $user = $this->find($userId);
        $user->update($data);
        return $user;
    }

    public function delete($userId): User
    {
        $user = $this->find($userId);
        $user->delete();
        return $user;
    }

    public function getFamilyMembers(int $parentId)
    {
        return $this->model->where('parent_id', $parentId)
            ->get();
    }
}
