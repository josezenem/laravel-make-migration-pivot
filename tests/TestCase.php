<?php

namespace Josezenem\LaravelMakeMigrationPivot\Tests;

use Josezenem\LaravelMakeMigrationPivot\LaravelMakeMigrationPivotServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelMakeMigrationPivotServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
