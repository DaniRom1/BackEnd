<?php

namespace App\Policies;

use App\Models\Announce;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncePolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Announce $model): bool
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

    public function update(User $user, Announce $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Announce $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Announce $model): bool
    {
        return false;
    }

    public function delete(User $user, Announce $model): bool
    {
        return false;
    }
}
