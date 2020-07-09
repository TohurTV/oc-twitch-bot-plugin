<?php namespace Tohur\Bot\Models;

use Model;

/**
 * Commands Model
 */
class Commands extends Model
{

    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_commands';


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
