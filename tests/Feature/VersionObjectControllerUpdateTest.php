<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VersionObjectControllerUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_value_and_show_latest(): void
    {
        $this->postJson('/api/object/', ["mykey" => "value 01"]);
        sleep(1);
        $this->postJson('/api/object/', ["mykey" => "value 02"]);

        $res = $this->get('/api/object/' . "mykey");

        $res->assertStatus(200)
            ->assertJsonPath("data.key", "mykey")
            ->assertJsonPath("data.value", "value 02");
    }

    public function test_update_value_and_show_by_timestamp(): void
    {
        $res01 = $this->postJson('/api/object/', ["mykey" => "value 01"]);
        $res01Data = $res01->decodeResponseJson();
        sleep(1);
        $res02 = $this->postJson('/api/object/', ["mykey" => "value 02"]);

        $resFi = $this->get('/api/object/' . "mykey?timestamp=" . $res01Data["data"]["utc_timestamp"]);
        $resFi->assertStatus(200)
            ->assertJsonPath("data.key", "mykey")
            ->assertJsonPath("data.value", "value 01");
    }
}
