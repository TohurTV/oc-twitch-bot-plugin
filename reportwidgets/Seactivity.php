<?php namespace Tohur\Bot\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Db;

class Seactivity extends ReportWidgetBase
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
                'default' => 'Streamelements Activity',
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

    protected function loadData()
    {

    }
}
