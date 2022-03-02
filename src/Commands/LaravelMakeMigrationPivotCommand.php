<?php

namespace Josezenem\LaravelMakeMigrationPivot\Commands;

use File;
use Illuminate\Console\GeneratorCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMakeMigrationPivotCommand extends GeneratorCommand
{
    public $signature = 'make:pivot
                            {firstModel?}
                            {secondModel?}
                            {--p|pivot= : Generate a Pivot Model}
                            {--table= : Hard code the table to migrate}';

    public $description = 'Create a new migration pivot class';

    public function handle(): bool|int|null
    {
        if ($this->argument('firstModel') && $this->argument('secondModel')) {
            $firstModel = $this->qualifyModel($this->argument('firstModel'));
            $secondModel = $this->qualifyModel($this->argument('secondModel'));


            $first_table = str((new $firstModel())->getTable())->singular()->value();
            $second_table = str((new $secondModel())->getTable())->singular()->value();

            $models[$first_table] = $firstModel;
            $models[$second_table] = $secondModel;

            ksort($models);

            $table = $this->option('table') ?? implode('_', array_keys($models));

            $first_model = \Arr::first($models);
            $second_model = \Arr::last($models);

            $uses = [
                'use Illuminate\Database\Migrations\Migration',
                'use Illuminate\Database\Schema\Blueprint',
                'use Illuminate\Support\Facades\Schema',
                'use ' . $first_model,
                'use ' . $second_model,
            ];
            sort($uses);

            $replacements = [
                '{{ table }}' => $table,
                '{{ first_model_name }}' => str($first_model)->afterLast('\\')->value(),
                '{{ second_model_name }}' => str($second_model)->afterLast('\\')->value(),
                '{{ first_table_id }}' => (new $first_model())->getKeyName(),
                '{{ first_table_foreign_id }}' => (new $first_model())->getForeignKey(),
                '{{ second_table_id }}' => (new $second_model())->getKeyName(),
                '{{ second_table_foreign_id }}' => (new $second_model())->getForeignKey(),
                '{{ uses }}' => implode(";\n", $uses) . ';',
                '{{ first_model_path }}' => $first_model,
                '{{ second_model_path }}' => $second_model,
            ];

            $migration_file = $this->getMigrationFile($table);
            if (File::exists($migration_file)) {
                $this->error(sprintf("Migration exists: **_create_category_%s_pivot_table.php", $table));

                return self::FAILURE;
            }

            $this->line("<info>Created Migration:</info> " . str($migration_file)->afterLast('/')->value());
            $this->makeMigration($migration_file, $replacements);
        }

        return self::SUCCESS;
    }

    public function makeMigration($migrationFile, $replacements)
    {
        $current_stub = $this->getStub();

        $contents = str_replace(array_keys($replacements), array_values($replacements), file_get_contents($current_stub));

        return File::put($migrationFile, $contents);
    }

    protected function getMigrationFile($table)
    {
        return PackageServiceProvider::generateMigrationName('create_'. $table . '_pivot_table', now());
    }

    protected function getStub()
    {
        $stub = '/stubs/migration.pivot.stub';

        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . '/../..'.$stub;
    }
}
