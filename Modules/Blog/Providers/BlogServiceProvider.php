<?php

namespace Modules\Blog\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Blog';

    public function boot(): void
    {
        $this->loadMigrations();
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    private function loadMigrations(): void
    {
        $isTestEnv = App::environment('testing');

        if ($isTestEnv) {
            $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        }
    }
}
