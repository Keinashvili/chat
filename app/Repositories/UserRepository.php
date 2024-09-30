<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::query()
            ->where('email', '=', $email)
            ->first();
    }

    public function getUserById(int $id)
    {
        return DB::table('users')
            ->where('id', '=', $id)
            ->first();
    }
}
