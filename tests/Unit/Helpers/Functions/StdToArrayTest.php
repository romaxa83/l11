<?php

namespace Tests\Unit\Helpers\Functions;

use Tests\TestCase;

class StdToArrayTest extends TestCase
{
    /** @test */
    public function success(): void
    {
        $std = new \stdClass();
        $std->test = 5;

        $this->assertEquals([
            "test" => 5
        ], std_to_array($std));
    }

    /** @test */
    public function success_multi_array(): void
    {
        $std = new \stdClass();
        $std_1 = new \stdClass();
        $std_1->test = 5;

        $std->test = $std_1;

        $this->assertEquals([
            "test" => ["test" => 5]
        ], std_to_array($std));
    }

    /** @test */
    public function empty_std(): void
    {
        $std = new \stdClass();

        $this->assertEquals([], std_to_array($std));
    }
}
