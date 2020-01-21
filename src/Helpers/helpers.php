<?php

if (!function_exists('isNotLumen')) {
    /**
     * check if application is lumen.
     *
     * @return bool
     */
    function isNotLumen(): bool
    {
        return !preg_match('/lumen/i', app()->version());
    }
}
