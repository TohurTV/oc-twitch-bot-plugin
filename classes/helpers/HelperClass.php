<?php

namespace Tohur\Bot\Classes\Helpers;

class HelperClass {

    function __construct() {
        
    }

    function remove_hashtags($string) {
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

    function remove_underscores($string) {
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

    function hoursandmins($time, $format = '%02d:%02d') {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

    function converttime($time) {
        $time1 = new \DateTime($time); // Event occurred time
        $time2 = new \DateTime(date('Y-m-d H:i:s')); // Current time
        $interval = $time1->diff($time2);

        $convertedtime = $interval->y . " Years, " . $interval->m . " Months, " . $interval->d . " Days ";
        return $convertedtime;
    }

    function convertuptime($time) {
        $time1 = new \DateTime($time); // Event occurred time
        $time2 = new \DateTime(date('Y-m-d H:i:s')); // Current time
        $interval = $time1->diff($time2);
        if ($interval->h == '00') {
            $convertedtime = $interval->i . " Mintues ";
        } elseif ($interval->h == '01') {
            $convertedtime = $interval->y . $interval->h . " Hour, " . $interval->i . " Mintues ";
        } else {
            $convertedtime = $interval->y . $interval->h . " Hours, " . $interval->i . " Mintues ";
        }
        return $convertedtime;
    }

}
