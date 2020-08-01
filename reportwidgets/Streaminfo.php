<?php

namespace Tohur\Bot\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Db;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class Streaminfo extends ReportWidgetBase {

    public function render() {
        try {
            $this->loadData();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('widget');
    }

    public function defineProperties() {
        return [
            'title' => [
                'title' => 'Widget title',
                'default' => 'Stream Info',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'widgetHeight' => [
                'title' => 'Height',
                'default' => '200',
                'type' => 'string'
            ],
        ];
    }

    protected function loadData() {
        
    }

    protected function title() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->getChannelinfo($Settings['Twitch']['channel']);

        return $apiCall[0]['title'];
    }

    protected function game() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->getChannelinfo($Settings['Twitch']['channel']);

        return $apiCall[0]['game_name'];
    }

    public function onUpdateStreaminfoWidget() {
        return [
            '#' . $this->alias => $this->render()
        ];
    }

}
