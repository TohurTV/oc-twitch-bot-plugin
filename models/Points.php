<?php namespace Tohur\Bot\Models;

use Model;

/**
 * Points Model
 */
class Points extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_points';


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

    public $belongsTo = [
        'users' => [Users::class, 'table' => 'tohur_bot_users']
    ];

}
