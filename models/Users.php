<?php

namespace Tohur\Bot\Models;

use Model;
use October\Rain\Database\Traits\Nullable;
use Tohur\Bot\Models\Roles;

/**
 * Users Model
 */
class Users extends Model {

    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_users';

    use Nullable; // This sets the trait to be used in this Model.

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['channel', 'twitch_id', 'twitch', 'discord_id', 'discord', 'points', 'watchtime', 'totalmessages', 'lastseen', 'ignore'];

    /**
     * @var array Nullable fields
     */
    public $nullable = [
        'points', // Define which fields should be inserted as NULL when empty
        'watchtime',
    ];

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
    public $belongsToMany = [
        'roles' => [Roles::class, 'table' => 'tohur_bot_user_roles']
    ];

}
