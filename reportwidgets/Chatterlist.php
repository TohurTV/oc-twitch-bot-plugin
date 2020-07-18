<?php

namespace Tohur\Bot\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Db;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class Chatterlist extends ReportWidgetBase {

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
                'default' => 'Chatter List',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'widgetHeight' => [
                'title' => 'Height',
                'default' => '700',
                'type' => 'string'
            ],
        ];
    }

    protected function loadData() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $viewerscall = $twitch->getChatusers($Settings['Twitch']['channel']);

        $this->vars['viewers'] = $viewerscall;
    }

    public function onUpdateChatterlistWidget() {
        return [
            '#' . $this->alias => $this->render()
        ];
    }

}
