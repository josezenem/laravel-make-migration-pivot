# Make Laravel Pivot Tables using the new Laravel 9 closure migration format

[![Latest Version on Packagist](https://img.shields.io/packagist/v/josezenem/laravel-make-migration-pivot.svg?style=flat-square)](https://packagist.org/packages/josezenem/laravel-make-migration-pivot)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/josezenem/laravel-make-migration-pivot/Check%20&%20fix%20styling?label=code%20style)](https://github.com/josezenem/laravel-make-migration-pivot/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/josezenem/laravel-make-migration-pivot.svg?style=flat-square)](https://packagist.org/packages/josezenem/laravel-make-migration-pivot)

This will allow you to create pivot table migration files using the new Laravel 9 closure migration format by simply passing two models.  Under the hood the system will inspect the two models to generate the pivot table and foreign key names. 

```bash
php artisan make:pivot Category Blog
```
Will generate the following migration
```php
return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_category', function (Blueprint $table) {
            $table->foreignIdFor(Blog::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Category::class)->constrained()->onDelete('cascade');
            $table->primary(['blog_id', 'category_id']);

            $table->index('blog_id');
            $table->index('category_id');
        });
    }
```
## Installation

You can install the package via composer:

```bash
composer require josezenem/laravel-make-migration-pivot --dev
```

## Usage

```bash
php artisan make:pivot Category Blog
```

Optionally, you can publish the stubs using

```bash
php artisan vendor:publish --tag="laravel-make-migration-pivot-stubs"
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jose Jimenez](https://github.com/josezenem)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
