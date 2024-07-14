<?php

namespace App\Console\Command;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ModelMakeCommand extends \Nwidart\Modules\Commands\Make\ModelMakeCommand
{
    protected $description = 'Create a new model, factory,
        seed and migration for the specified module.';

    public function handle(): int
    {
        if (parent::handle() === E_ERROR) {
            return E_ERROR;
        }

        $this->forceMakeSeed();
        $this->forceMakeFactory();
        $this->forceMakeMigration();

        return 0;
    }

    protected function forceMakeSeed(): void
    {
        if ($this->option('seed')) {
            return;
        }
        $seedName = "{$this->getModelName()}Seeder";

        $this->call('module:make-seed', array_filter([
            'name' => $seedName,
            'module' => $this->argument('module'),
        ]));
    }

    protected function forceMakeFactory(): void
    {
        if ($this->option('factory')) {
            return;
        }
        $this->call('module:make-factory', array_filter([
            'name' => $this->getModelName(),
            'module' => $this->argument('module'),
        ]));
    }

    private function forceMakeMigration(): void
    {
        if ($this->option('migration')) {
            return;
        }
        $migrationName = 'create_' . $this->createMigrationName() . '_table';
        $this->call('module:make-migration', [
            'name' => $migrationName,
            'module' => $this->argument('module'),
        ]);
    }

    private function createMigrationName(): string
    {
        $pieces = preg_split('/(?=[A-Z])/', $this->argument('model'), -1, PREG_SPLIT_NO_EMPTY);

        $result = Arr::map($pieces, fn ($item) => Str::lower($item));
        $lastIndex = count($result) - 1;
        $result[$lastIndex] = Str::plural($result[$lastIndex]);

        return implode('_', $result);
    }

    private function getModelName()
    {
        return Str::studly($this->argument('model'));
    }
}
