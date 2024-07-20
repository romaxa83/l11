<?php

namespace Modules\Auth\Actions;

use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsController;
use Modules\Auth\Resources\UserResource;

class GetCurrentUserInfo
{
    use AsController;

    public function handle(): UserResource
    {
        $user = Auth::user();

        return new UserResource($user);
    }
}
