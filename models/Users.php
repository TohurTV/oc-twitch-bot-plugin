<?php namespace Tohur\Bot\Models;

use Model;

/**
 * Users Model
 */
class Users extends Model
{

    public $timestamps = true;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_users';


    /**
     * @var array Fillable fields
     */
    protected $fillable = ['channel', 'twitch_id', 'twitch', 'discord_id', 'discord', 'points', 'watchtime', 'totalmessages', 'lastseen', 'ignore'];


    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
