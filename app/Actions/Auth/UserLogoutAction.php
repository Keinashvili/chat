<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use Illuminate\Http\Request;

class UserLogoutAction
{
    public function execute(Request $request): void
    {
        $request->user()->token()->revoke();
    }
}
