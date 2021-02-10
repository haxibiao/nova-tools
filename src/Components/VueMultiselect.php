<?php

namespace Haxibiao\Nova\Components;

use Laravel\Nova\Fields\Field;

class VueMultiselect extends Field
{
    public $name = 'VUE多选';

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
