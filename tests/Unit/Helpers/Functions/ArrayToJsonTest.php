<?php

namespace Tests\Unit\Helpers\Functions;

use Tests\TestCase;

class ArrayToJsonTest extends TestCase
{
    /** @test */
    public function success(): void
    {
        $arr = ["test" => 4];

        $this->assertEquals("{\"test\":4}", array_to_json($arr));
    }

    /** @test */
    public function success_multi_array(): void
    {
        $arr = ["test" => ['test' => 6]];

        $this->assertEquals('{"test":{"test":6}}', array_to_json($arr));
    }

    /** @test */
    public function empty_json(): void
    {
        $arr = [];

        $this->assertEquals('[]', array_to_json($arr));
    }
}
