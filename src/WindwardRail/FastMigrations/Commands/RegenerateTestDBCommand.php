<?php namespace WindwardRail\FastMigrations\Commands;

use App;
use Artisan;
use Config;
use File;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RegenerateTestDBCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fast-migrations:run';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Migrate and seed the stored test databases.';

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
		/* Check that the current application environment matches the one specified in configuration */
		$environment = Config::get('fast-migrations::config.environment');
		if( ! App::environment($environment)){
			$this->error("Environments do not match! Run command with --env='{$environment}'");
			return;
		}

		/* Set up paths and filename constants */
		$path = app_path() . Config::get('fast-migrations::config.db_path');;
		$suites = Config::get('fast-migrations::suites');
		$db_suffix = Config::get('fast-migrations::config.db_suffix');

		/* Migrate and seed each database registered in the suites configuration file */
		foreach($suites as $suite_name => $class_name){
            echo("Migrating and seeding $suite_name suite.\n");

			$stub_path = $path . $suite_name . $db_suffix . '.sqlite';
            if( ! File::exists($stub_path)){
                File::put($stub_path, '');
            }
            Artisan::call('migrate', [
                '--database' => $suite_name,
            ]);
            Artisan::call('db:seed', [
                '--class' => $class_name,
                '--database' => $suite_name,
            ]);
        }
	}
}
