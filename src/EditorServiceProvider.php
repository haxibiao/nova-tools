<?php

namespace Haxibiao\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class EditorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes();

        Nova::serving(function (ServingNova $event) {
            Nova::script('VueEditor', __DIR__ . '/../dist/js/editor.js');
            Nova::style('VueEditor', __DIR__ . '/../dist/css/editor.css');
        });
    }

    /**
     * @Author      XXM
     * @DateTime    2019-01-24
     * @description [API路由先暂时全部放这里 后期优化出来]
     * @return      [type]        [description]
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        //先临时处理 后期优化成功controller
        Route::middleware('nova')->prefix('nova-vendor/vue-editor')->group(function () {
            Route::any('upload-image', function (Request $request) {
                if ($imageFile = $request->file('image')) {
                    $image = \App\Image::saveImage($imageFile);
                    return ['url' => $image->url];
                }
            });
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
