<?php

namespace Haxibiao\Nova;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class QuestionViewer extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('haxibiao-nova', __DIR__ . '/../dist/js/qviewer.js');
        Nova::style('haxibiao-nova', __DIR__ . '/../dist/css/qviewer.css');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('haxibiao-nova::navigation_qviewer');
    }
}
