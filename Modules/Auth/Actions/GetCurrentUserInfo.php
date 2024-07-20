<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsController;
use Modules\Auth\Resources\UserResource;
use OpenAPI\Operation\ApiGet;
use OpenAPI\Responses\ResponseJsonSuccess;

#[ApiGet(
    path: '/api/v1/current-user',
    tags: ['Auth'],
    description: 'Get current user info',
    auth: true
)]
#[ResponseJsonSuccess(UserResource::class)]

class GetCurrentUserInfo
{
    use AsController;

    public function handle(): UserResource
    {
        $user = Auth::user();

        return new UserResource($user);
    }
}
