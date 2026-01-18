<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\SecurityMonitoringMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Log CSRF token failures
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'CSRF token mismatch.'], 419);
            }
            
            \App\Services\SecurityLogService::log(
                'csrf_failure',
                'medium',
                $request,
                'CSRF token validation failed'
            );
            
            return redirect()->back()->withErrors(['csrf' => 'CSRF token mismatch. Please try again.']);
        });
    })->create();
