<?php

namespace Haxibiao\Nova\Components;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class ShuaziViewer extends Tool
{
    public $name = '刷子查询';

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('haxibiao-nova', __DIR__ . '/../dist/js/shuazi.js');
        Nova::style('haxibiao-nova', __DIR__ . '/../dist/css/shuazi.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('haxibiao-nova::navigation_shuazi');
    }
}
