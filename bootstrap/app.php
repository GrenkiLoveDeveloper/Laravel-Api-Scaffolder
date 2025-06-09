<?php

declare(strict_types=1);

use App\Console\CronSchedule as ScheduleHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {})
    ->withSchedule(new ScheduleHandler)
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->renderable(function (ModelNotFoundException $e, Request $request) {

            // Если запрос ожидает ответ в формате JSON
            if ($request->wantsJson()) {
                return response()->json(
                    [
                        'error' => __('messages.model_not_found', ['model' => $e->getModel()]),
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }
        });
    })->create();
