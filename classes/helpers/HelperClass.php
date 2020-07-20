<?php

namespace Tohur\Bot\Classes\Helpers;

class HelperClass {

    function __construct() {
        
    }

    /**
     * Get human readable time difference between 2 dates
     *
     * Return difference between 2 dates in year, month, hour, minute or second
     * The $precision caps the number of time units used: for instance if
     * $time1 - $time2 = 3 days, 4 hours, 12 minutes, 5 seconds
     * - with precision = 1 : 3 days
     * - with precision = 2 : 3 days, 4 hours
     * - with precision = 3 : 3 days, 4 hours, 12 minutes
     *
     * From: http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
     * Code snippet credit: https://gist.github.com/ozh/8169202
     *
     * Modified to support localization strings in Laravel.
     *
     * @param mixed $time1 a time (string or timestamp)
     * @param mixed $time2 a time (string or timestamp)
     * @param integer $precision Optional precision
     * @return string time difference
     */
    public static function getDateDiff($time1, $time2, $precision = 2) {
        if ($precision === 0) {
            $precision = 2;
        }

        // If not numeric then convert timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }
        // If time1 > time2 then swap the 2 values
        if ($time1 > $time2) {
            list($time1, $time2) = array($time2, $time1);
        }
        // Set up intervals and diffs arrays
        $intervals = array('year', 'month', 'week', 'day', 'hour', 'minute', 'second');
        $diffs = array();
        foreach ($intervals as $interval) {
            // Create temp time from time1 and interval
            $ttime = strtotime('+1 ' . $interval, $time1);
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }
            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }
        $count = 0;
        $times = array();
        foreach ($diffs as $interval => $value) {
            // Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
            // Add value and interval if value is bigger than 0
            if ($value > 0) {
                // Add value and interval to times array
                $times[] = trans_choice('time.' . $interval, $value, [
                    'value' => $value,
                ]);

                $count++;
            }
        }
        // Return string with times
        return implode(", ", $times);
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

}
