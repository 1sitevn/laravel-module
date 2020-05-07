<?php

if (!function_exists('app_path')) {
    /**
     * @param $suffix
     * @return string
     */
    function app_path($suffix)
    {
        return __DIR__ . '/dist/app' . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
    }
}

if (!function_exists('database_path')) {
    /**
     * @param $suffix
     * @return string
     */
    function database_path($suffix)
    {
        return __DIR__ . '/dist/database' . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
    }
}

if (!function_exists('base_path')) {
    /**
     * @param $suffix
     * @return string
     */
    function base_path($suffix)
    {
        return __DIR__ . '/dist' . (strpos($suffix, '/') === 0 ? $suffix : '/' . $suffix);
    }
}

if (!function_exists('date')) {
    /**
     * @param $format
     * @return string
     */
    function date($format)
    {
        return 'date';
    }
}
