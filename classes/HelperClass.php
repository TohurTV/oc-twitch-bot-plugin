<?php


namespace Tohur\Bot\Classes;


class HelperClass
{
    function __construct()
    {

    }
    function remove_hashtags($string)
    {
        // Get ready for some regex magic...
        return
            // Remove remaining hashes but keep the text inside the caption
            trim(str_replace('#', '',
                trim(preg_replace('/^(.+?)#\w+$/m', '${1}', // Edge case #hash1
                    trim(preg_replace('/^(.+?)#\w+ #\w+$/m', '${1}', // Edge case #hash1 #hash2
                        // Main case where there are at least three hashtags at the end of the string
                        trim(preg_replace('/^(.+?)#\w+ (#\w+ )+#\w+$/m', '${1}',
                            trim($string)))))))));
    }

    function remove_underscores($string)
    {
        // Get ready for some regex magic...
        return
            // Remove remaining hashes but keep the text inside the caption
            trim(str_replace('_', '',
                trim(preg_replace('/^(.+?)_\w+$/m', '${1}', // Edge case #hash1
                    trim(preg_replace('/^(.+?)_\w+ _\w+$/m', '${1}', // Edge case #hash1 #hash2
                        // Main case where there are at least three hashtags at the end of the string
                        trim(preg_replace('/^(.+?)_\w+ (_\w+ )+_\w+$/m', '${1}',
                            trim($string)))))))));
    }
}