<?php

namespace App\Actions\Auth;
use App\Models\User;

class LogoutUserAction
{
    public function execute(User $user): bool
    {
        return $user->currentAccessToken()->delete();
    }
}
