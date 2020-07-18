<?php



Route::get('/bot/auth/twitch', array("as" => "tohur_bot_twitch",'uses' => '\Tohur\Bot\Controllers\TwitchController@getTwitchRedirect', 'middleware' => ['web']));

Route::get('/bot/auth/twitch/callback', array("as" => "tohur_bot_twitch_callback",'uses' => '\Tohur\Bot\Controllers\TwitchController@getTwitchCallback', 'middleware' => ['web']));

