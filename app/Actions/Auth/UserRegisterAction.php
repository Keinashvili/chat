<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\{Hash};

class UserRegisterAction
{
    public function execute(UserRegisterRequest $request): void
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    }
}
