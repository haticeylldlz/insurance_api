<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;

class CarPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Car $car): bool
    {
        return $user->isAdmin() || $car->owner?->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Car $car): bool
    {
        return $user->isAdmin() || $car->owner?->user_id === $user->id;
    }

    public function delete(User $user, Car $car): bool
    {
        return $user->isAdmin() || $car->owner?->user_id === $user->id;
    }
}
