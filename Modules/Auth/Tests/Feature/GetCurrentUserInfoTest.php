<?php

namespace Modules\Auth\Tests\Feature;

use Modules\Auth\Models\User;
use Tests\TestCase;

class GetCurrentUserInfoTest extends TestCase
{
    /** @test */
    public function canGetCurrentUserInfo(): void
    {
        $user = User::factory()->create();

        $user = $user->fresh();

        $this->actingAsUser($user);

        $this->getJson(route('api.v1.current-user'))
            ->assertValidRequest()
            ->assertValidResponse(200)
//            ->assertSuccessful()
//            ->assertJson([
//                'id' => $user->id,
//                'name' => $user->name,
//            ])
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
