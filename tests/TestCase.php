<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure test database file exists
        $testDb = database_path('testing.sqlite');
        if (!file_exists($testDb)) {
            touch($testDb);
        }
    }
}
