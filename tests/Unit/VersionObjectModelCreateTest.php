<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\VersionObject;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class VersionObjectModelCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_version_object(): void
    {
        $o = VersionObject::generate(["test" => "value 01"]);
        $v = $o->getData();

        $this->assertInstanceOf(VersionObject::class, $o);
        $this->assertEquals('test', $v["key"]);
        $this->assertEquals('value 01', $v["value"]);
    }

    public function test_create_version_object_no_parameter(): void
    {
        $o = VersionObject::generate();
        $this->assertEquals(null, $o);
    }

    public function test_create_version_object_non_array_parameter(): void
    {
        $o = VersionObject::generate( "test" );
        $this->assertEquals(null, $o);
    }

    public function test_create_version_object_with_multiple_key_value_pair(): void
    {
        $o = VersionObject::generate(["mykey" => "value1", "mykey2" => "value1"]);
        $this->assertEquals(null, $o);
    }

    public function test_create_version_object_with_null_value(): void
    {
        $o = VersionObject::generate(["test" => null]);
        $this->assertEquals(null, $o);
    }

    public function test_create_version_object_with_empty_string_value(): void
    {
        $o = VersionObject::generate(["test" => ""]);
        $this->assertEquals(null, $o);
    }

    public function test_create_version_object_with_spaces_value(): void
    {
        $o = VersionObject::generate(["test" => "                        "]);
        $this->assertEquals(null, $o);
    }

    public function test_create_version_object_with_integer_value(): void
    {
        $o = VersionObject::generate(["test" => 111]);
        $v = $o->getData();

        $this->assertInstanceOf(VersionObject::class, $o);
        $this->assertEquals('test', $v["key"]);
        $this->assertEquals(111, $v["value"]);
    }

    public function test_validate_version_object_value_double(): void
    {
        $o = VersionObject::generate(["test" => 1.1111]);
        $v = $o->getData();

        $this->assertInstanceOf(VersionObject::class, $o);
        $this->assertEquals('test', $v["key"]);
        $this->assertEquals(1.1111, $v["value"]);
    }

    public function test_create_version_object_with_empty_array_value(): void
    {
        $o = VersionObject::generate(["test" => []]);
        $v = $o->getData();

        $this->assertInstanceOf(VersionObject::class, $o);
        $this->assertEquals('test', $v["key"]);
        $this->assertEquals([], $v["value"]);
    }

    public function test_create_version_object_with_non_empty_array_value(): void
    {
        $o = VersionObject::generate(["test" => [1, 2, 3]]);
        $v = $o->getData();

        $this->assertInstanceOf(VersionObject::class, $o);
        $this->assertEquals('test', $v["key"]);
        $this->assertEquals([1, 2, 3], $v["value"]);
    }

    public function test_create_version_object_with_non_empty_assoc_array_value(): void
    {
        $o = VersionObject::generate(["test" => ["key1" => "1", "key2" => "2"]]);
        $v = $o->getData();

        $this->assertInstanceOf(VersionObject::class, $o);
        $this->assertEquals('test', $v["key"]);
        $this->assertEquals(["key1" => "1", "key2" => "2"], $v["value"]);
    }

    public function test_create_version_object_with_long_key(): void
    {
        $o = VersionObject::generate([
            "LoremipsumdolorsitametconsecteturadipiscingelitseddoeiusmodtemporincididuntutlaboreetdoloremagnaaliquaUtenimadminimveniamquisnostrudexercitationullamcolaborisnisiutaliquipexeacommodoconsequatDuisauteiruredolorinreprehenderitinvoluptatevelitessecillumdoloreeufugiatnullapariaturExcepteursintoccaecatcupidatatnonproidentsuntinculpaquiofficiadeseruntmollitanimidestlaborum" => "value"
        ]);
        $this->assertEquals(null, $o);
    }

    public function test_create_version_object_with_long_value(): void
    {
        $str = "
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
        
        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.
        ";
        //strlen( $str ) - 2200

        $arr = [];

        for ($x = 0; $x < 1000; $x++) {
            $arr[] = $str;
        }
        //strlen( implode("\n", $arr) ) - 2200999

        $o = VersionObject::generate([
            "key_long_value" => implode("\n", $arr)
        ]);
        $this->assertEquals(null, $o);
    }

}
