<?php

namespace App\Helper;

class Data
{
    public static function get($item, $key, $default = null)
    {
        if (!strpos($key, '.')) {
            if (is_object($item)) {
                return $item->{$key} ?? $default;
            }

            return $item[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment) {
            if (is_object($item) && isset($item->{$segment})) {
                $item = $item->{$segment};
            } elseif (isset($item[$segment])) {
                $item = $item[$segment];
            } else {
                return $default;
            }
        }

        return $item;
    }
}
