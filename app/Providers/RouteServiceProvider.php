<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {
    public const string HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void {

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
    protected function configureRateLimiting(): void {

        RateLimiter::for('api', function ($request) {
            $userId = $request->user() ? $request->user()->id : null;

            return Limit::perMinute(100)->by($userId ?? $request->ip());
        });
    }
}
