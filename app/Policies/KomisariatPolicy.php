<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Komisariat;

class KomisariatPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function view(User $user, Komisariat $komisariat): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function update(User $user, Komisariat $komisariat): bool
    {
        return $user->hasRole('Super Admin');
    }

    public function delete(User $user, Komisariat $komisariat): bool
    {
        return $user->hasRole('Super Admin');
    }
}
