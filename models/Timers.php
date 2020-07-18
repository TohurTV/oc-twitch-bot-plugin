<?php namespace Tohur\Bot\Models;

use Model;
use Tohur\Bot\Models\TimerGroups;

/**
 * Timers Model
 */
class Timers extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_timers';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['timersgroups_id', 'name', 'response'];


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
        'timersgroups' => [TimerGroups::class, 'table' => 'tohur_bot_timer_groups']
    ];

}
