<?php namespace Tohur\Bot\Models;

use Model;
use Tohur\Bot\Models\Roles;
/**
 * Commands Model
 */
class CustomCommands extends Model
{

    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_custom_commands';


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
    
    public $belongsTo = [
        'roles' => [Roles::class, 'table' => 'tohur_bot_roles']
    ];

}
