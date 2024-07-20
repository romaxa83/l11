<?php

namespace Modules\Auth\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Modules\Auth\Models\PersonalAccessToken;
use Modules\Auth\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Auth';

    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        $this->loadMigrations();
        $this->enforceMorphAliases();
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }

    private function loadMigrations(): void
    {
        $isTestEnv = App::environment('testing');
        $runningInConsoleMigrateCommand = App::runningConsoleCommand('module:migrate');

        /** @infection-ignore-all  */
        if ($isTestEnv || $runningInConsoleMigrateCommand) {
            $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
        }
    }

    private function enforceMorphAliases(): void
    {
        Relation::enforceMorphMap([
            User::MORPH_NAME => User::class,
        ]);
    }
}
