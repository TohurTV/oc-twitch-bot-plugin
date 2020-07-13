<?php namespace Tohur\Bot\Models;

use Model;

/**
 * DicordLivePosts Model
 */
class DicordLivePosts extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'tohur_bot_dicord_live_posts';

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['channel', 'discord', 'sent'];


    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

}
