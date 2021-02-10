<?php

namespace Haxibiao\Nova;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class VueMultiselectServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('vue-multiselect', __DIR__ . '/../dist/js/vuemultiselect.js');
            Nova::style('vue-multiselect', __DIR__ . '/../dist/css/vuemultiselect.css');
        });
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
