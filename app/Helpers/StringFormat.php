<?php

if (!function_exists('kebabToCamel')) {
    function kebabToCamel($kebab): array|string
    {
        return str_replace(' ', '', lcfirst(ucwords(str_replace('-', ' ', $kebab))));
    }
}

if (!function_exists('kebabToPascal')) {
    function kebabToPascal($kebab): array|string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $kebab)));
    }
}

