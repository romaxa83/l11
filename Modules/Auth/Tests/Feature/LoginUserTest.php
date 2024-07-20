<?php

namespace Modules\Auth\Tests\Feature;

use Modules\Auth\Models\PersonalAccessToken;
use Modules\Auth\Models\User;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    public const array CREDENTIALS = [
        'email' => 'some_email@test.com',
        'password' => 'some_password',
    ];

    /** @test */
    public function canLogin(): void
    {
        User::factory()->create(self::CREDENTIALS);

        $this->postJson(route('api.v1.login'), self::CREDENTIALS)
            ->assertSuccessful()
            ->assertJsonStructure([
                'token'
            ])
        ;
    }

    /** @test */
    public function canLoginEmailCaseInsensitive(): void
    {
        $email = 'some_email@test.com';
        $password = 'some_password';

        User::factory()->create([
            'email' => $email,
            'password' => $password,
        ]);

        $this->postJson(route('api.v1.login'), [
            'email' => 'some_eMaiL@teSt.com',
            'password' => $password,
        ])
            ->assertSuccessful()
        ;;
    }

    /** @test */
    public function cannotLoginWithWrongPassword(): void
    {
        $user = User::factory()->create(self::CREDENTIALS);

        $this->postJson(route('api.v1.login'), [
            'email' => $user->email,
            'password' => 'wrong_password',
        ])
            ->assertStatus(401)
            ->assertJson([
                'message' => "Unauthenticated."
            ])
        ;
    }

    /** @test */
    public function cannotLoginWithWrongEmail(): void
    {
        User::factory()->create(self::CREDENTIALS);

        $this->postJson(route('api.v1.login'), [
            'email' => 'soem_wrong_email@test.com',
            'password' => self::CREDENTIALS['password'],
        ])
            ->assertStatus(401)
            ->assertJson([
                'message' => "Unauthenticated."
            ])
        ;
    }

    /** @test */
    public function canLoginAsActualUser(): void
    {
        User::factory()->create();

        $user = User::factory()->create(self::CREDENTIALS);

        User::factory()->create();

        $response = $this->postJson(route('api.v1.login'), self::CREDENTIALS);

        $plainTextToken = $response->json('token');

        $token = PersonalAccessToken::findToken($plainTextToken);

        $this->assertEquals($user->id, $token->tokenable_id);
    }

    /** @test */
    public function cannotLoginWithoutEmail(): void
    {
        $this->postJson(route('api.v1.login'), [
            'password' => 'some_password',
        ])
            ->assertInvalid(['email']);
    }

    /** @test */
    public function cannotLoginWithoutPassword(): void
    {
        $this->postJson(route('api.v1.login'), [
            'email' => 'some_email@test.com',
        ])
            ->assertInvalid(['password']);
    }

    /** @test */
    public function canHideTokenIdDisplay(): void
    {
        User::factory()->create(self::CREDENTIALS);

        $response = $this->postJson(route('api.v1.login'), self::CREDENTIALS);

        $plainTextToken = $response->json('token');

        $hasPipe = str_contains($plainTextToken, '|');

        $this->assertFalse($hasPipe);
    }
}
