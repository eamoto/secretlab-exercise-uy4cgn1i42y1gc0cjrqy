<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VersionObjectControllerListingTest extends VersionObjectControllerBaseTest
{
    /**
     * A basic feature test example.
     */
    public function test_list_empty_database(): void
    {
        $res = $this->get(self::REQ_URI . "get_all_records");

        $res->assertStatus(200)
            ->assertJsonPath("data", []);
    }
    public function test_list_with_records(): void
    {
        $this->postJson(self::REQ_URI, ["mykey01" => "value1"]);
        $this->postJson(self::REQ_URI, ["mykey02" => "value2"]);
        $this->postJson(self::REQ_URI, ["mykey03" => "value3"]);
        $this->postJson(self::REQ_URI, ["mykey04" => "value4"]);

        $res = $this->get(self::REQ_URI . "get_all_records");

        $res->assertStatus(200)
            ->assertJsonPath("data.0.key", "mykey01")
            ->assertJsonPath("data.0.value", "value1")
            ->assertJsonPath("data.1.key", "mykey02")
            ->assertJsonPath("data.1.value", "value2")
            ->assertJsonPath("data.2.key", "mykey03")
            ->assertJsonPath("data.2.value", "value3")
            ->assertJsonPath("data.3.key", "mykey04")
            ->assertJsonPath("data.3.value", "value4")
            ;
    }

}
