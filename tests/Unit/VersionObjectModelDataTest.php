<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\VersionObject;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class VersionObjectModelDataTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_data_structure(): void
    {
        $o = VersionObject::generate(["test" => "value 01"]);
        $d = $o->getData();

        $this->assertArrayHasKey('utc_timestamp', $d);
        $this->assertArrayHasKey('key', $d);
        $this->assertArrayHasKey('value', $d);
    }

    public function test_check_data_values(): void
    {
        VersionObject::generate(["test" => "value 01"]);

        $o = VersionObject::lookUp("test");
        $d = $o->getData();

        $this->assertEquals('value 01', $d["value"]);
        $this->assertEquals('test', $d["key"]);
        $this->assertEquals($o->utc_timestamp, $d["utc_timestamp"]);
    }

    public function test_check_data_value_array(): void
    {
        VersionObject::generate(["test" => [1, 2, 3]]);

        $o = VersionObject::lookUp("test");
        $d = $o->getData();

        $this->assertEquals([1, 2, 3], $d["value"]);
    }
}
