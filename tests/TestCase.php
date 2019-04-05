<?php

namespace Tests;

use CoursesTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use IndustriesTableSeeder;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();
        $this->seed(CoursesTableSeeder::class);
        $this->seed(IndustriesTableSeeder::class);
    }
}
