<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\Handler as MiddlewareHandler;
use App\Exceptions\Handler as ExceptionHandler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(new MiddlewareHandler())
    ->withExceptions(new ExceptionHandler())
    ->withSchedule(new \App\Console\ScheduleHandler())
    ->create()
    ;
