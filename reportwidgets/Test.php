<?php namespace Tohur\Bot\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Db;

class Test extends ReportWidgetBase
{
    public function render()
    {
        try {
            $this->loadData();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('widget');
    }

    public function defineProperties()
    {
        return [
            'title' => [
                'title' => 'Widget title',
                'default' => 'Test',
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
                'default' => '',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'darkmode' => [
                'title'             => 'Dark Mode',
                'type'              => 'checkbox',
                'default'           => 1
            ],
        ];
    }

    protected function loadData()
    {

    }
}
