<?php

namespace Modules\Auth\Actions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsController;
use Modules\Auth\Models\PersonalAccessToken;
use OpenAPI\Operation\ApiPost;
use OpenAPI\Responses\ResponseNoContent;

#[ApiPost(
    path: '/api/v1/logout',
    tags: ['Auth'],
    description: 'Logout',
    auth: true
)]
#[ResponseNoContent()]

class LogoutUser
{
    use AsController;

    public function handle(): Response
    {
        /** @var PersonalAccessToken $token */
        $token = Auth::user()->currentAccessToken();

        $token->delete();

        return response()->noContent();
    }
}
