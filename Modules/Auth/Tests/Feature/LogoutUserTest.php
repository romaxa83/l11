<?php

namespace Modules\Auth\Tests\Feature;

use Modules\Auth\Models\User;
use Modules\Auth\Tests\Builders\UserBuilder;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
    protected UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->userBuilder = resolve(UserBuilder::class);
    }

    /** @test */
    public function canLogout(): void
    {
        /** @var $user User */
        $user = $this->userBuilder->create();

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
