<?php

namespace Tohur\Bot\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Db;
use Tohur\Bot\Classes\Helpers\FunctionsClass;

class Stats extends ReportWidgetBase {

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
                'default' => 'Stats',
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

    protected function uptime() {
        $function = new FunctionsClass();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);

        $uptime = $function->uptime($Settings['Twitch']['channel']);

        return $uptime;
    }

    protected function viewercount() {
        $function = new FunctionsClass();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);

        $viewercount = $function->viewers($Settings['Twitch']['channel']);

        return $viewercount;
    }

    protected function subcount() {
        $function = new FunctionsClass();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);

        $subcount = $function->subcount($Settings['Twitch']['channel']);

        return $subcount;
    }

    protected function totalviews() {
        $function = new FunctionsClass();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $totalViewers = $function->totalviews($Settings['Twitch']['channel']);

        return $totalViewers;
    }

    protected function hostcount() {
        $function = new FunctionsClass();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $hostcount = $function->hostcount($Settings['Twitch']['channel']);

        return $hostcount;
    }

    protected function followers() {
        $function = new FunctionsClass();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $followercount = $function->followcount($Settings['Twitch']['channel']);

        return $followercount;
    }

    protected function title() {
        $function = new FunctionsClass();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $title = $function->channelTitle($Settings['Twitch']['channel']);

        return $title;
    }

    protected function game() {
        $function = new FunctionsClass();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $game = $function->channelGame($Settings['Twitch']['channel']);

        return $game;
    }

    public function onUpdateStatsWidget() {
        return [
            '#' . $this->alias => $this->render()
        ];
    }

}
