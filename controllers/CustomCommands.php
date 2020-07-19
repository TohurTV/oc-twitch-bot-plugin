<?php

namespace Tohur\Bot\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Custom Commands Back-end Controller
 */
class CustomCommands extends Controller {

    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];
    public $pageTitle = "Custom Commands";

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct() {
        parent::__construct();

        BackendMenu::setContext('Tohur.Bot', 'bot', 'customcommands');
    }

}
