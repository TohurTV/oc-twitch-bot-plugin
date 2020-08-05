<?php namespace Tohur\Bot\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * BotPermissionEditor Form Widget
 */
class BotPermissionEditor extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'tohur_bot_bot_permission_editor';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('botpermissioneditor');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/botpermissioneditor.css', 'Tohur.Bot');
        $this->addJs('js/botpermissioneditor.js', 'Tohur.Bot');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
