<?php

use App\Providers\FirebaseServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens([
            '/pusher/webhooks',
        ]);
        $middleware->alias([
            'permission_check' => \App\Http\Middleware\PermissionCheck::class,
            'role' => Spatie\Permission\Middleware\RoleMiddleware::class,
            'has_root_user' => \App\Http\Middleware\CheckHasRootUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        FirebaseServiceProvider::class,
    ])
    ->create();
    $app->singleton(
        Illuminate\Contracts\Console\Kernel::class,
        App\Console\Kernel::class
    );

    return $app;
