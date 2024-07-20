<?php

namespace Tests;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Auth\Models\User;
use Spectator\Spectator;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    private bool $dropTypes = true;

    protected function setUp(): void
    {
        parent::setUp();

        Spectator::using('api-docs.json');
    }

    public function actingAsUser(
        Authenticatable|User $user,
        $guard = 'sanctum',
    ): TestCase
    {
        $token = $user->createToken();

        $user->withAccessToken($token->accessToken);

        app('auth')->guard($guard)->setUser($user);
        app('auth')->shouldUse($guard);

        return $this;
    }
}
