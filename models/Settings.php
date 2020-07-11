<?php

namespace Tohur\Bot\Models;

use Model;

class Settings extends Model {

    public $implement = ['System.Behaviors.SettingsModel'];
    // A unique code
    public $settingsCode = 'tohur_bot_settings';
    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
    protected $cache = [];

}
