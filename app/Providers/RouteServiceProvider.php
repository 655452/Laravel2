<?php

namespace App\Providers;

use App\Models\Addon;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
                $this->mapApiRoutes();
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            $this->mapWebRoutes();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapWebRoutes()
    {
        if(file_exists(storage_path('installed'))){
            $addons = Addon::all();
            if(!blank($addons)) {
                foreach($addons as $addon) {
                    if(isset(json_decode($addon->files)->web_route)) {
                        if(File::exists(__DIR__."/../../routes/{$addon->slug}.php")) {
                            Route::middleware('web')
                                ->group(__DIR__."/../../routes/{$addon->slug}.php");
                        }
                    }
                }
            }
        }
    }


    protected function mapApiRoutes()
    {
        if(file_exists(storage_path('installed'))){
            $addons = Addon::all();
            if(!blank($addons)) {
                foreach($addons as $addon) {
                    if(isset(json_decode($addon->files)->api_route)) {
                        if(File::exists(__DIR__."/../../routes/{$addon->slug}.php")) {
                            Route::prefix('api')
                                ->middleware('api')
                                ->group(__DIR__."/../../routes/{$addon->slug}-api.php");
                        }
                    }
                }
            }
        }
    }
}
