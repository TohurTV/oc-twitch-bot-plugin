<?php

namespace Tohur\Bot\Components;

use Cms\Classes\ComponentBase;
use Tohur\Bot\Models\Users;

class Toppoints extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Top User points Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * @inheritdoc
     */
    public function defineProperties() {
        return [
            'limit' => [
                'title' => 'tohur.bot::lang.settings.limit_title',
                'description' => 'tohur.bot::lang.settings.limit_description',
                'type' => 'string',
                'default' => '10'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function onRun() {

        $this->pointItems = $this->page['pointItems'] = $this->PointLeaders();
    }

    /**
     * @return array
     */
    public function PointLeaders() {
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        
        $users = Users::where('channel', $Settings['Twitch']['channel'])
                ->whereNotNull('points')
                ->orderBy('points', 'desc')
                ->take($this->property('limit'))
                ->get();

        return $users;
    }

}
