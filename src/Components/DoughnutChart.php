<?php

namespace Haxibiao\Nova\Components;

use Laravel\Nova\Card;

class DoughnutChart extends Card
{
    public $name = "Doughnut图表";

    public $component = 'doughnut-chart';
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    public function withName($name)
    {
        $this->name = $name;
        return $this->withMeta(['name' => $this->name]);
    }

    public function withData($data)
    {
        return $this->withMeta(['data' => $data]);
    }
}
