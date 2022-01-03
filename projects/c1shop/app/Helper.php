<?php

namespace App;


use Illuminate\Support\Str;

class Helper
{

    /**
     * Escaping of quotes.
     *
     * @param $string
     *
     * @return string|null
     */
    public static function escapingQuotes($string)
    {
        return (is_string($string)) ? preg_replace('/(")+/', '', $string) : null;
    }

    /**
     * @param \App\string $string
     *
     * @return string
     */
    public static function sanitizeFilename($string)
    {
        $string = strip_tags($string);
        $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
        $string = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $string);
        $string = strtolower($string);
        $string = html_entity_decode( $string, ENT_QUOTES, "utf-8" );
        $string = htmlentities($string, ENT_QUOTES, "utf-8");
        $string = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $string);
        //$string = str_replace(' ', '-', $string);
        //$string = rawurlencode($string);
        $string = str_replace('%', '-', $string);
        return $string;
    }

    /**
     * Transliterate string.
     *
     * @param $string
     *
     * @return string
     */
    public static function translit($string)
    {
        return Str::slug($string);
    }

    /**
     * Render SVG icon.
     *
     * @param $name
     * @param string $class
     */
    public static function renderIcon($name, $class = '')
    {
        print "<svg class=\"icon icon-{$name} {$class}\"><use xlink:href=\"#{$name}\"></use></svg>";
    }

}
