<?php namespace Tohur\Bot\Models;

use Model;

/**
 * watched Model
 */
class Watched extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_watched';


    /**
     * @var array Fillable fields
     */
    protected $fillable = [];


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

    public $belongsTo = [
        'users' => [Users::class, 'table' => 'tohur_bot_users']
    ];

}
