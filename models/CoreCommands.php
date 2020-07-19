<?php

namespace Tohur\Bot\Models;

use Model;

/**
 * CoreCommands Model
 */
class CoreCommands extends Model {

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_core_commands';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'command', 'response'];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
