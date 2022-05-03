<?php

namespace App\Helpers\String;

class StringHelper
{
    public static function cleanStringIntoAnArray(array &$stringArray): void
    {
        $cleanString = static function (&$value){
            if (is_string($value))
            {
                $value = self::safeString($value);
            }
        };

        array_walk($stringArray, $cleanString);
    }

    public static function safeString(string $string): string
    {
        return self::quoteStringWithSlashes(self::removeTags($string));
    }

    /**
     * @see addslashes()
     * @param string $string
     * @return string
     */
    public static function quoteStringWithSlashes(string $string): string
    {
        return addslashes ($string);
    }

    /**
     * @see filter_var()
     * @param string $string
     * @return string
     */
    public static function removeTags(string $string): string
    {
        $str = preg_replace('/\x00|<[^>]*>?/', '', self::removeSpaces($string));

        return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
    }

    public static function removeSpaces(string $string):string
    {
        return trim($string);
    }
}
