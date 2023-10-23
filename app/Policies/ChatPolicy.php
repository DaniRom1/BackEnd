<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Chat $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return true;
    }

    public function storeBulk(User $user): bool
    {
        return false;
    }

    public function update(User $user, Chat $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Chat $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Chat $model): bool
    {
        return false;
    }

    public function delete(User $user, Chat $model): bool
    {
        return false;
    }
}
