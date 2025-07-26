<?php

use App\Http\Middleware\Authacces;
use App\Http\Middleware\Checkrole;
use Illuminate\Foundation\Application;
use App\Http\Middleware\Adminpemerintah;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => Checkrole::class,
            'admin_or_government' => Adminpemerintah::class,
            'authacces' => Authacces::class,
        ]);

        $middleware->alias([
            'user' => Checkrole::class,
            'user' => UserMiddleware::class,
            'authacces' => Authacces::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
