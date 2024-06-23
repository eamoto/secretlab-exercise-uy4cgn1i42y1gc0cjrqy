<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VersionObjectControllerBaseTest extends TestCase
{
    use RefreshDatabase;

    final const REQ_URI = '/api/object/';

    protected function log($data){
        fwrite(STDERR, print_r($data, TRUE));
    }
}
