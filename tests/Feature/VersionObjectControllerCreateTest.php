<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VersionObjectControllerCreateTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_create_version_object(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => "value1"]);

        $res->assertStatus(200)
            ->assertJsonPath("data.key", "mykey")
            ->assertJsonPath("data.value", "value1");
    }

    public function test_create_version_object_with_multiple_key_value_pair(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => "value1", "mykey2" => "value1"]);
        $res->assertUnprocessable();
    }

    public function test_create_version_object_with_null_value(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => null]);
        $res->assertUnprocessable();
    }

    public function test_create_version_object_with_empty_string_value(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => ""]);
        $res->assertUnprocessable();
    }

    public function test_create_version_object_with_spaces_value(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => "              "]);
        $res->assertUnprocessable();
    }

    public function test_create_version_object_with_number_value(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => 111]);
        $res->assertUnprocessable();
    }

    public function test_create_version_object_with_empty_array_value(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => []]);
        $res->assertStatus(200);
    }

    public function test_create_version_object_with_non_empty_array_value(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => [1, 2, 3, 4]]);
        $res->assertStatus(200);
    }

    public function test_create_version_object_with_non_empty_assoc_array_value(): void
    {
        $res = $this->postJson('/api/object/', ["mykey" => ["key1" => "1", "key2" => "2"]]);
        $res->assertStatus(200);
    }
}
