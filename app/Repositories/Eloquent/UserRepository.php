<?php

declare(strict_types=1);

namespace WolfShop\Repositories\Eloquent;

use WolfShop\Models\User;

class UserRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::firstWhere('email', $email);
    }

    public function createPlainTextToken(User $user): string
    {
        return $user->createToken(
            'Api token for ' . $user->email,
            ['*'],
            now()->addDay()
        )->plainTextToken;
    }
}
