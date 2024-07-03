<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\VersionObject;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Services\VersionObjectValidator;

class VersionObjectModelValidateValueTest extends TestCase
{
    use RefreshDatabase;

    public function test_validate_version_object_value_string(): void
    {
        $o = VersionObjectValidator::do("Value");
        $this->assertTrue($o);
    }

    public function test_validate_version_object_value_array(): void
    {
        $o = VersionObjectValidator::do([1, 2, 3]);
        $this->assertTrue($o);
    }

    public function test_validate_version_object_no_parameter(): void
    {
        $o = VersionObjectValidator::do();
        $this->assertTrue($o);
    }

    public function test_validate_version_object_value_assoc_array(): void
    {
        $o = VersionObjectValidator::do(["test" => 1, "test2" => 2]);
        $this->assertTrue($o);
    }

    public function test_validate_version_object_value_null(): void
    {
        $o = VersionObjectValidator::do(null);
        $this->assertTrue($o);
    }

    public function test_validate_version_object_value_empty_string(): void
    {
        $o = VersionObjectValidator::do("");
        $this->assertFalse($o);
    }

    public function test_validate_version_object_value_spaces(): void
    {
        $o = VersionObjectValidator::do("           ");
        $this->assertFalse($o);
    }

    public function test_validate_version_object_value_integer(): void
    {
        $o = VersionObjectValidator::do(1);
        $this->assertTrue($o);
    }

    public function test_validate_version_object_value_double(): void
    {
        $o = VersionObjectValidator::do(1.111111);
        $this->assertTrue($o);
    }

    public function test_validate_version_object_value_numeric_string(): void
    {
        $o = VersionObjectValidator::do("1");
        $this->assertTrue($o);
    }

    public function test_validate_version_object_value_empty_array(): void
    {
        $o = VersionObjectValidator::do([]);
        $this->assertTrue($o);
    }

    public function test_validate_version_object_value_long_length_string(): void
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

        $o = VersionObjectValidator::do(implode("\n", $arr));
        $this->assertFalse($o);
    }

    public function test_validate_version_object_value_large_array(): void
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

        $o = VersionObjectValidator::do($arr);
        $this->assertFalse($o);
    }
}
