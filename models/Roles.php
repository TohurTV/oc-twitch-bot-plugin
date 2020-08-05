<?php namespace Tohur\Bot\Models;

use Model;
use Tohur\Bot\Models\Users;
/**
 * Roles Model
 */
class Roles extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_roles';

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'description'
    ];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'users'       => [Users::class, 'table' => 'tohur_bot_user_roles'],
        'users_count' => [Users::class, 'table' => 'tohur_bot_user_roles', 'count' => true]
    ];
}
