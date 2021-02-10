<?php

namespace Haxibiao\Nova\Components;

use Exception;
use Laravel\Nova\Fields\Select;

class SelectAutoComplete extends Select
{
    public $name = "选择自动完成";

    public $component = 'select-auto-complete';

    /**
     * @var bool
     */
    public $maxResults = 30;

    public $maxHeight = '220px';

    public $displayUsingLabels = false;

    public $placeholder = null;

    /**
     * SelectAutoComplete constructor.
     * @param               $name
     * @param null          $attribute
     * @param callable|null $resolveCallback
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta(['maxResults' => (int) $this->maxResults ?: 30,
            'maxHeight'                   => $this->maxHeight]);
    }

    /**
     * @param null $default
     * @return mixed
     */
    function default($default = null) {
        if (null !== $default) {
            return $this->withMeta([__FUNCTION__=> $default]);
        }
    }

    /**
     * @param int $maxResults
     * @return mixed
     * @throws \Exception
     */
    public function maxResults(int $maxResults)
    {
        if ($maxResults > 0) {
            $this->maxResults = $maxResults;

            return $this->withMeta([__FUNCTION__=> $this->maxResults]);
        }
        throw new Exception('Max results value has to be a positive interge!');
    }

    /**
     * @param string $maxHeight
     * @return mixed
     */
    public function maxHeight(string $maxHeight)
    {
        if ($maxHeight) {
            $this->maxHeight = trim($maxHeight);

            return $this->withMeta([__FUNCTION__=> $this->maxHeight]);
        }
    }

    /**
     * Display values using their corresponding specified labels.
     *
     * @return $this
     */
    public function displayUsingLabels()
    {
        $this->displayUsingLabels = true;

        return $this->withMeta([__FUNCTION__=> $this->displayUsingLabels]);
    }

    public function placeholder($placeholer)
    {
        if ($placeholer) {
            $this->placeholder = trim($placeholer);

            return $this->withMeta([__FUNCTION__=> $this->placeholder]);
        }
    }
}
