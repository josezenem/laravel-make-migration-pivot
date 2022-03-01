<?php

namespace Josezenem\LaravelMakeMigrationPivot;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Josezenem\LaravelMakeMigrationPivot\Commands\LaravelMakeMigrationPivotCommand;

class LaravelMakeMigrationPivotServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-make-migration-pivot')
            ->hasCommand(LaravelMakeMigrationPivotCommand::class);

        $this->publishes([
            __DIR__.'/../stubs/' => base_path('stubs'),
        ], 'laravel-make-migration-pivot-stubs');
    }
}
