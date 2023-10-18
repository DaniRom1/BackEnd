<?php

namespace App\Policies;

use App\Models\Picture;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PicturePolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Picture $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return false;
    }

    public function storeBulk(User $user): bool
    {
        return false;
    }

    public function update(User $user, Picture $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Picture $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Picture $model): bool
    {
        return false;
    }

    public function delete(User $user, Picture $model): bool
    {
        return false;
    }
}
