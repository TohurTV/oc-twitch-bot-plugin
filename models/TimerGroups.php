<?php namespace Tohur\Bot\Models;

use Model;
use Tohur\Bot\Models\Timers;

/**
 * TimerGroups Model
 */
class TimerGroups extends Model
{
    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_timer_groups';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'timetorun'];

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
        'timers' => [Timers::class, 'table' => 'tohur_bot_timers']
    ];

}
