<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TimoutCmd extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'user:timeout';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'This runs every minute and if the timestamp on their user account is less than 1 minute it logs the user out of rooms.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$users = DB::table('users_schema')
                     ->where('updated_at', '<', 'UNIX_TIMESTAMP() - 65')
                     ->where('chat_room', '>', 0)
                     ->orWhere('video_room', '>', 0)
                     ->update(array('chat_room'=>0, 'video_room'=>0));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
