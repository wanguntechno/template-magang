<?php

use Illuminate\Support\Str;
//adi dan budi => adiDanBudi
if (!function_exists('string_to_camel_case')) {
    function string_to_camel_case(String $string): String
    {
        return Str::came($string);
    }
}

//adi dan budi => AdiDanBudi
if (!function_exists('string_to_pascal_case')) {
    function string_to_pascal_case(String $string, String $saparator = ' '): String
    {
        return str_replace($saparator, '', ucwords($string, $saparator));
    }
}

//adi dan budi => adi_dan_budi
if (!function_exists('string_to_snake_case')) {
    function string_to_snake_case(String $string): String
    {
        return Str::snake($string);
    }
}

//adi dan budi => adi-dan-budi
if (!function_exists('string_to_kebab_case')) {
    function string_to_kebab_case(String $string): String
    {
        return Str::kebab($string);
    }
}
