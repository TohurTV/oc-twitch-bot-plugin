<?php

namespace Tohur\Bot\Models;

use Model;
use RestCord\DiscordClient;


class Settings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];
    // A unique code
    public $settingsCode = 'tohur_bot_settings';
    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
    protected $cache = [];

    public function listChannels($fieldName, $value, $formData)
    {
        $settings = \Tohur\bot\Models\Settings::instance()->get('bot', []);
        $discord = new DiscordClient(['token' => $settings['Discord']['token']]);
        $apiCall = $discord->guild->getGuildChannels(['guild.id' => 463042081468710912]);
        if ($fieldName == 'Settings[bot][Discord][guildid]') {

            $apiCall = $discord->getGuildChannels($settings['Discord']['guildid']);
            foreach ($apiCall as $obj) {

                $options = ["'.$obj->id.'" => "'.$obj->name.'"];

            }
return $options;
        }
    }
}
