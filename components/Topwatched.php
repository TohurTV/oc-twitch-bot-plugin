<?php

namespace Tohur\Bot\Components;

use Cms\Classes\ComponentBase;
use Tohur\Bot\Models\Users;

class Topwatched extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Topwatched Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties() {
        return [];
    }

    /**
     * @return array
     */
    public function WatchLeaders() {
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);

        $users = Users::where('channel', $Settings['Twitch']['channel'])
                ->whereNotNull('watchtime')
                ->orderBy('watchtime', 'desc')
                ->take($this->property('limit'))
                ->get();

        return $users;
    }

    function hoursandmins($time, $format = '%02d:%02d') {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }

}
