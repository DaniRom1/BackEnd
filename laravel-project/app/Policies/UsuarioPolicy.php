<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Auth\Access\HandlesAuthorization;

class UsuarioPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Usuario $model): bool
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

    public function update(User $user, Usuario $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Usuario $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Usuario $model): bool
    {
        return false;
    }

    public function delete(User $user, Usuario $model): bool
    {
        return false;
    }
}
