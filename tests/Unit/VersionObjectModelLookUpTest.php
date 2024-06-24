<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\VersionObject;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class VersionObjectModelLookUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_look_up_version_object(): void
    {
        VersionObject::generate(["test" => "value 01"]);

        $o = VersionObject::lookUp("test");
        $v = $o->getData();

        $this->assertEquals('value 01', $v["value"]);
    }

    public function test_look_up_version_object_no_parameter(): void
    {
        $o = VersionObject::lookUp();
        $this->assertEquals(null, $o);
    }

    public function test_look_up_version_object_not_found(): void
    {
        $o = VersionObject::lookUp("hey");
        $this->assertEquals(null, $o);
    }

    public function test_look_up_version_object_latest(): void
    {
        VersionObject::generate(["test" => "value 01"]);
        VersionObject::generate(["test" => "value 02"]);
        VersionObject::generate(["test" => "value 03"]);

        $o = VersionObject::lookUp("test");
        $v = $o->getData();

        $this->assertEquals('value 03', $v["value"]);
    }

    public function test_look_up_version_object_latest_with_timestamp(): void
    {
        $l1 = VersionObject::generate(["test" => "value 01"]);
        sleep(1);
        $l2 = VersionObject::generate(["test" => "value 02"]);
        sleep(1);
        $l3 = VersionObject::generate(["test" => "value 03"]);

        $o = VersionObject::lookUp("test", $l2->utc_timestamp);
        $v = $o->getData();

        $this->assertEquals('value 02', $v["value"]);
    }

    public function test_look_up_version_object_latest_with_unknown_timestamp(): void
    {
        VersionObject::generate(["test" => "value 01"]);
        VersionObject::generate(["test" => "value 02"]);
        VersionObject::generate(["test" => "value 03"]);

        $o = VersionObject::lookUp("test", 111111111);
        $this->assertEquals(null, $o);
    }
}
