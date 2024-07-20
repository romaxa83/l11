<?php

namespace Modules\Auth\Tests\Feature;

use Modules\Auth\Models\User;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
    /**
     * @test
     */
    public function canLogout(): void
    {
        $user = User::factory()->create();

        $this->actingAsUser($user);

        $token = $user->currentAccessToken();

        $this->postJson(route('api.v1.logout'))
            ->assertNoContent()
        ;

        $this->assertSoftDeleted('personal_access_tokens', [
            'id' => $token->id,
        ]);
    }

    /** @test */
    public function cannotLogoutAsGuest(): void
    {
        $this->postJson(route('api.v1.logout'))
            ->assertStatus(401);
    }
}
