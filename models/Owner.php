<?php namespace Tohur\Bot\Models;

use Model;

/**
 * Owner Model
 */
class Owner extends Model
{


    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_owners';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['twitch_id', 'twitch', 'discord_id', 'discord', 'game', 'livepostsent', 'tweetsent'];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
