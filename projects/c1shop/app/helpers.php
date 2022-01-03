<?php

use App\Helper;


if (! function_exists('icon')) {
    /**
     * Render SVG icon.
     *
     * @param $name
     * @param string $class
     */
    function icon($name, $class = '')
    {
        Helper::renderIcon($name, $class);
    }
}

