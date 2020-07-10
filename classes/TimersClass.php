<?php


namespace Tohur\Bot\Classes;

use Tohur\Bot\Classes\FunctionsClass;
use Tohur\Bot\Models\TimerGroups;
use Tohur\Bot\Models\Timers;
define("INTERVAL", 5 );
class TimersClass
{
    function __construct($socket, $ex, $config)
    {
        $this->start($socket, $ex, $config);
    }

    function checkForStopFlag() { // completely optional
        // Logic to check for a program-exit flag
        // Could be via socket or file etc.
        // Return TRUE to stop.
        return false;
    }

    function start($socket, $ex, $config) {
        $active = true;
        $nextTime   = microtime(true) + INTERVAL; // Set initial delay

        while($active) {
            usleep(1000); // optional, if you want to be considerate

            if (microtime(true) >= $nextTime) {
                $this->sendtimer($socket, $ex, $config);
                $nextTime = microtime(true) + INTERVAL;
            }

            // Do other stuff (you can have as many other timers as you want)

            $active = !$this->checkForStopFlag();
        }
    }

    function sendtimer($socket, $ex, $config)
    {
        $master = $config['master'];
        $timersDB = Timers::all();
        foreach ($timersDB as $timerDB) {
            $timersTime = TimerGroups::where('id', $timerDB->timersgroups_id)->get();
            $functions = new FunctionsClass();
            $parts = explode("!", $ex[0]);
            $user = substr($parts['0'], 1);

            $replace = array(
                '{$user}' => $ex[2]
            );
            $formated = strtr($timerDB->response, $replace);
            sleep(1);
            fputs($socket, "PRIVMSG " . $ex[2] . " :" . $formated . " \n");
        }
        // call itself again after 10 seconds;
    }
}