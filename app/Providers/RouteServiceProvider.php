<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {
    protected static string $home = '/';

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
     * Привязка роута HOME к env.
     *
     * @return mixed
     */
    protected static function getHome(): mixed {
        return config('app.home', '/');
    }

    /**
     * Ограничение количества запросов в минуту.
     */
    protected function configureRateLimiting(): void {

        RateLimiter::for('api', function ($request) {
            $userId = $request->user() ? $request->user()->id : null;

            return Limit::perMinute(200)->by($userId ?? $request->ip());
        });
    }
}
