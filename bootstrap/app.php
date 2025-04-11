<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Định nghĩa alias cho middleware
        $middleware->alias([
            'role'            => \App\Http\Middleware\RoleMiddleware::class,
            'verify'          => \App\Http\Middleware\VerifyCustomMiddleware::class,
            'verify-register' => \App\Http\Middleware\RegisterMiddleware::class,
            'verify-register2' => \App\Http\Middleware\Register2Middleware::class,
            'sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
