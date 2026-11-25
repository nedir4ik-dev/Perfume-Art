<?php

use App\Http\Middleware\ActivityLogger;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckPermission;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'      => AdminMiddleware::class,
            'permission' => CheckPermission::class,
        ]);

        $middleware->appendToGroup('web', [
            LocaleMiddleware::class,
            ActivityLogger::class,
        ]);

        $middleware->redirectUsersTo(fn() => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function (\Throwable $e) {
            $request = app(Request::class);

            if ($request->is('admin*') && class_exists(ActivityLogger::class)) {
                try {
                    $logger = new ActivityLogger();
                    $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;

                    $response = response()->json(['message' => $e->getMessage()], $status < 100 || $status > 599 ? 500 : $status);
                    $response->exception = $e;

                    $logger->handle($request, function () use ($response) {
                        return $response;
                    });
                } catch (\Exception $ex) {
                }
            }
        });
    })
    ->create();
