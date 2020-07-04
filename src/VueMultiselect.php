<?php

namespace Haxibiao\Nova;

use Laravel\Nova\Fields\Field;

class VueMultiselect extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'vue-multiselect';

    public function options($value)
    {
        return $this->withMeta(['options' => $value]);
    }

    public function height($value)
    {
        return $this->withMeta(['height' => $value]);
    }
}
