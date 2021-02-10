<?php

namespace Techouse\SelectAutoComplete;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class SelectAutoCompleteServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('select-auto-complete', __DIR__ . '/../dist/js/select-auto-complete.js');
            Nova::style('select-auto-complete', __DIR__ . '/../dist/css/select-auto-complete.css');
        });
    }

    public function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }
        Route::middleware(['nova'])
            ->prefix('nova-vendor/select-auto-complete')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
