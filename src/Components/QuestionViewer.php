<?php

namespace Haxibiao\Nova\Components;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class QuestionViewer extends Tool
{
    public $name      = "创建题目";
    public $component = 'question-viewer';

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
