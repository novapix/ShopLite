<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    public static function userHasRole(array|string $roles): bool
    {
        $user = Auth::user();
        if (!$user || !$user->relationLoaded('role')) {
            $user = $user?->load('role');
        }

        $roleName = $user?->role?->role;

        return in_array($roleName, (array) $roles);
    }
}
