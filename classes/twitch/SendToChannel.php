<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Twitchirc\IRC\Response;
use Tohur\Twitchirc\Twitchirc;

class SendToChannel {

//This is going to hold our TCP/IP connection
    var $socket;
//This is going to hold all of the messages both server and client
    var $ex = array();

    /*

      Construct item, opens the server connection, logs the bot in
      @param array

     */

    function __construct($config, $response) {
        $this->socket = fsockopen($config['server'], $config['port']);
        $this->login($config);
        $this->main($config, $response);
    }

    /*

      Logs the bot in on the server
      @param array

     */

    function login($config) {
        $this->send_data('PASS', $config['password']);
        $this->send_data('USER', $config['nick']);
        $this->send_data('NICK', $config['nick']);
        $this->join_channel($config['channel']);
    }

    /*

      This is the workhorse function, grabs the data from the server and displays on the browser

     */

    function main($config, $response) {
        $data = fgets($this->socket, 256);

        echo nl2br($data);

        flush();

        $this->ex = explode(' ', $data);

        if ($this->ex[0] == 'PING') {
            $this->send_data('PONG', $this->ex[1]); //Plays ping-pong with the server to stay connected.
        }

        $this->send_data('PRIVMSG ' . $config['channel'] . ' :', $response);
    }

    function send_data($cmd, $msg = null) { //displays stuff to the broswer and sends data to the server.
        if ($msg == null) {
            fputs($this->socket, $cmd . "\n\r");
            echo '<strong>' . $cmd . '</strong><br />';
        } else {

            fputs($this->socket, $cmd . ' ' . $msg . "\n\r");
            echo '<strong>' . $cmd . ' ' . $msg . '</strong><br />';
        }
    }

    function join_channel($channel) { //Joins a channel, used in the join function.
        if (is_array($channel)) {
            foreach ($channel as $chan) {
                $this->send_data('JOIN', $chan);
            }
        } else {
            $this->send_data('JOIN', $channel);
        }
    }

}

