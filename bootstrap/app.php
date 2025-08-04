<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Gabungkan SEMUA alias di dalam satu array ini.
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'profile.completed' => \App\Http\Middleware\CheckProfileCompletion::class, // Ini ide bagus!
        ]);

        // Daftarkan middleware yang berjalan otomatis di sini.
        $middleware->web(append: [
            \App\Http\Middleware\CheckProfileCompletion::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();