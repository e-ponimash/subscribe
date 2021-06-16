<?php

namespace Tests;

use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TestSeeder::class);
        \Artisan::call('passport:install');
    }
}
