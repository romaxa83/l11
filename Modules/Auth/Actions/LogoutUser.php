<?php

namespace Modules\Auth\Actions;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsController;
use Modules\Auth\Models\PersonalAccessToken;

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
