<?php

namespace Josezenem\LaravelMakeMigrationPivot;

use Josezenem\LaravelMakeMigrationPivot\Commands\LaravelMakeMigrationPivotCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
