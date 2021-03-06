<?php

namespace Tohur\Bot\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Db;

class Chat extends ReportWidgetBase {

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
                'default' => 'Chat',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'widgetHeight' => [
                'title' => 'Height',
                'default' => '700',
                'type' => 'string'
            ],
            'parentDomain' => [
                'title' => 'Parent Domain',
                'default' => 'test.com',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'darkmode' => [
                'title' => 'Dark Mode',
                'type' => 'checkbox',
                'default' => 1
            ],
        ];
    }

    protected function loadData() {
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        if (!strlen($Settings['Twitch']['channel']) && !strlen($Settings['Twitch']['botname']) && !strlen($Settings['Discord']['owner'])) {
            echo 'Please go fill out Twitch info in bot settings';
        } else {
            $channel = $Settings['Twitch']['channel'];
        }
        
        $this->vars['channel'] = $channel;
    }

}
