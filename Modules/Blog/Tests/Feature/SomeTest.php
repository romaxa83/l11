<?php

namespace Modules\Blog\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SomeTest extends TestCase
{
    /** @test */
    public function example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
