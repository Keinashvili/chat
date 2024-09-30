<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Exceptions\LoginException;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

readonly  class UserLoginAction
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @throws LoginException
     */
    public function execute(UserLoginRequest $request): string
    {
        $user = $this->userRepository->findByEmail($request->email);

        if (
            $user
            && Hash::check($request->password, $user->password)
        ) {
            return $user->createToken('token')->plainTextToken;
        }

        throw new LoginException();
    }
}
