<?php

namespace Modules\Auth\Tests\Unit\Models;

use Modules\Auth\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function canSaveOnlyLowerCasedEmail()
    {
        $email = 'TestWrongcase@test.com';
        $user = User::create([
            'name' => 'No matter',
            'email' => $email,
            'password' => 'no_matter',
        ]);

        $this->assertDatabaseHas('users', [
            'users.id' => $user->id,
            'email' => strtolower($email),
        ]);
    }

    /** @test */
    public function canSaveOnlyHashedPassword()
    {
        $password = 'some_password';
        $user = User::create([
            'name' => 'No matter',
            'email' => 'some_name',
            'password' => $password,
        ]);

        $this->assertDatabaseHas('users', [
            'users.id' => $user->id,
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'password' => $password,
        ]);
    }

    /** @test */
    public function hasMorphMapDefinition()
    {
        $user = User::factory()->create();

        $this->assertEquals(User::MORPH_NAME, $user->getMorphClass());
    }
}
