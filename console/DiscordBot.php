<?php namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Classes\DiscordBotClass;

class DiscordBot extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'bot:discord';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    private $run = true;

    public function __construct()
    {
        parent::__construct();
        $this->config = array(
            'token' => ''
        );

    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
            return $this->DiscordBot();
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    public function DiscordBot()
    {
        $Discordbot = new DiscordBotClass($this->config);
    }
}