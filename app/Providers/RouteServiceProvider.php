<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Custom namespace for api controllers.
     *
     * @var string
     */
    public const API_NAMESPACE = 'App\Http\Controllers\Api\\';

    /**
     * Custom namespace for web controllers.
     *
     * @var string
     */
    public const WEB_NAMESPACE = 'App\Http\Controllers\Web\\';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->namespace(self::API_NAMESPACE)
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace(self::WEB_NAMESPACE)
                ->group(base_path('routes/web.php'));
        });
    }
}
