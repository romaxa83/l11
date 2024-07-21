<?php

namespace Modules\Auth\Tests\Feature;

use Modules\Auth\Models\User;
use Modules\Auth\Tests\Builders\UserBuilder;
use Tests\TestCase;

class GetCurrentUserInfoTest extends TestCase
{
    protected UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->userBuilder = resolve(UserBuilder::class);
    }

    /** @test */
    public function canGetCurrentUserInfo(): void
    {
        /** @var $user User */
        $user = $this->userBuilder->create();

        $user = $user->fresh();

        $this->actingAsUser($user);

        $this->getJson(route('api.v1.current-user'))
            ->assertValidRequest()
            ->assertValidResponse(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
            ])
        ;
    }

    /** @test */
    public function cannotGetCurrentUserInfoWhenGuest(): void
    {
        $this->getJson(route('api.v1.current-user'))
            ->assertStatus(401)
            ->assertJson([
                'message' => "Unauthenticated."
            ])
        ;
    }
}
