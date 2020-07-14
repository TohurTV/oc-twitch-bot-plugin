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
    protected $fillable = ['twitch_id', 'twitch', 'discord_id', 'discord'];


    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */

    public $hasMany = [
        'points' => [Points::class, 'table' => 'tohur_bot_points'],
        'watched' => [Points::class, 'table' => 'tohur_bot_watched']
    ];
}
