<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const string HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {

        // ограничение количества запросов
        $this->configureRateLimiting();

        $this->routes(function (): void {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    /**
     * Ограничение количества запросов в минуту.
     */
    protected function configureRateLimiting(): void
    {
        // RateLimiter::for('api', function ($request) {

        //     return Limit::perMinute(160)->response(function ($request) {

        //         Log::warning('Rate limit exceeded for user', [
        //             'ip' => $request->ip(),
        //             'user_id' => optional($request->user())->id,
        //         ]);

        //         return response('Too many requests', 429);
        //     });
        // });
    }
}
