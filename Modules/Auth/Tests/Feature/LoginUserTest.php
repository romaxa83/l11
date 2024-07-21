<?php

namespace Modules\Auth\Tests\Feature;

use Modules\Auth\Models\PersonalAccessToken;
use Modules\Auth\Tests\Builders\UserBuilder;
use Tests\TestCase;

class LoginUserTest extends TestCase
{
    public const array CREDENTIALS = [
        'email' => 'some_email@test.com',
        'password' => 'some_password',
    ];

    protected UserBuilder $userBuilder;

    public function setUp(): void
    {
        parent::setUp();

        $this->userBuilder = resolve(UserBuilder::class);
    }

    /** @test */
    public function canLogin(): void
    {
        $this->userBuilder->credentials(self::CREDENTIALS)->create();

        $this->postJson(route('api.v1.login'), self::CREDENTIALS)
            ->assertValidRequest()
            ->assertValidResponse(200)
        ;
    }

    /** @test */
    public function canLoginEmailCaseInsensitive(): void
    {
        $email = 'some_email@test.com';
        $password = 'some_password';

        $this->userBuilder->credentials([
            'email' => $email,
            'password' => $password,
        ])->create();

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
        $user = $this->userBuilder->credentials(self::CREDENTIALS)->create();

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
        $this->userBuilder->credentials(self::CREDENTIALS)->create();

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
        $this->userBuilder->create();

        $user = $this->userBuilder->credentials(self::CREDENTIALS)->create();

        $this->userBuilder->create();

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
        $this->userBuilder->credentials(self::CREDENTIALS)->create();

        $response = $this->postJson(route('api.v1.login'), self::CREDENTIALS);

        $plainTextToken = $response->json('token');

        $hasPipe = str_contains($plainTextToken, '|');

        $this->assertFalse($hasPipe);
    }
}
