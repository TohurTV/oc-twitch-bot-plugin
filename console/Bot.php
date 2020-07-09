<?php namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Classes\BotClass;

class Bot extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'bot:bot';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    private $run = true;

    public function __construct()
    {
        parent::__construct();
        $this->config = array(
            'serverHost' => 'irc.chat.twitch.tv',
            'serverPort' => 6667,
            'serverSsl' => false,
            'serverChannels' => array('#tohur'),
            'name' => 'tohur_bot',
            'nick' => 'tohur_bot',
            'master' => 'tohur',
            'pass' => 'oauth:5nx4y4odalttvshg9k169plcownihp'
        );

    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {

        if ($this->argument('start')) {
            return $this->fire();
        }
        if ($this->argument('stop')) {

            return $this->shutdown();
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['start', InputArgument::OPTIONAL, 'An example argument.'],
            ['stop', InputArgument::OPTIONAL, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    public function fire()
    {
        $bot = new BotClass($this->config);
    }

    public function start()
    {
        $this->output->writeln('Gracefully stopping worker...');

        // When set to false, worker will finish current item and stop.
        $this->run = true;
    }

    public function shutdown()
    {
        $this->output->writeln('Gracefully stopping worker...');

        // When set to false, worker will finish current item and stop.
        $this->run = false;
    }
}