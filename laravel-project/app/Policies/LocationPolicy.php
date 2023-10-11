<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Location $model): bool
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

    public function update(User $user, Location $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Location $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Location $model): bool
    {
        return false;
    }

    public function delete(User $user, Location $model): bool
    {
        return false;
    }
}
