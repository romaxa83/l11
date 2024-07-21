<?php

namespace Tests\Unit\Helpers\Functions;

use Tests\TestCase;

class JsonToArrayTest extends TestCase
{
    /** @test */
    public function success(): void
    {
        $json = "{\"test\": 5}";

        $this->assertEquals([
            "test" => 5
        ],json_to_array($json));
    }

    /** @test */
    public function success_multi_array(): void
    {
        $json = "{\"test\": {\"test\": 2}}";

        $this->assertEquals([
            "test" => ["test" => 2]
        ],json_to_array($json));
    }

    /** @test */
    public function empty_json(): void
    {
        $json = "{}";

        $this->assertEquals([],json_to_array($json));
    }

    /** @test */
    public function empty_string(): void
    {
        $json = '';

        $this->assertEquals([],json_to_array($json));

        $json = ' ';

        $this->assertEquals([],json_to_array($json));
    }
}
