<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class APIResponseHelperTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_response_structure_success(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => "value1"]);
        $res->assertStatus(200)
            ->assertJsonStructure(["code", "messages", "data"]);
    }

    public function test_api_response_structure_fail(): void
    {
        $res = $this->postJson('/api/object/', []);
        $res->assertUnprocessable()
            ->assertJsonStructure(["code", "messages"]);
    }

}
