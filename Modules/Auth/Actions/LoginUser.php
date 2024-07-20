<?php

namespace Modules\Auth\Actions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsController;
use Modules\Auth\Models\User;
use Modules\Auth\Requests\LoginRequest;
use Modules\Auth\Resources\LoginUserResource;
use Throwable;

class LoginUser
{
    use AsController;

    /**
     * @throws Throwable
     */
    public function handle(LoginRequest $request): LoginUserResource
    {
        $login = Auth::attempt($request->only(['email', 'password']));

        throw_unless($login, new AuthenticationException());

        /** @var User $user */
        $user = $request->user();

        $token = $user->createToken()->plainTextToken;

        return new LoginUserResource([
            'token' => $token,
        ]);
    }
}
