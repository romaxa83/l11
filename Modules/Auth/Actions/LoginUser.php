<?php

namespace Modules\Auth\Actions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsController;
use Modules\Auth\Models\User;
use Modules\Auth\Requests\LoginRequest;
use Modules\Auth\Resources\LoginUserResource;
use OpenAPI\Operation\ApiPost;
use OpenAPI\Request\RequestJson;
use OpenAPI\Responses\ResponseJsonSuccess;
use OpenAPI\Responses\ResponseUnauthorized;
use Throwable;

#[ApiPost(
    path: '/api/v1/login',
    tags: ['Auth'],
    description: 'Login user'
)]
#[ResponseUnauthorized]
#[ResponseJsonSuccess(LoginUserResource::class)]
#[RequestJson(LoginRequest::class)]

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
