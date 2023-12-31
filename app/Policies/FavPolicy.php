<?php

namespace App\Policies;

use App\Models\Fav;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FavPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Fav $model): bool
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

    public function update(User $user, Fav $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Fav $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Fav $model): bool
    {
        return false;
    }

    public function delete(User $user, Fav $model): bool
    {
        return true;
    }
}
