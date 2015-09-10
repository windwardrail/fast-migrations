<?php namespace WindwardRail\FastMigrations;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RegenerateTestDBCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:stubs';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Regenerate the test database stubs';

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
        $suites = Config::get('wcc.test_suites');

        foreach($suites as $suite_name => $class_name){
            echo("Migrating and seeding $suite_name suite.\n");

            $path = app_path() . '/tests/_data/';
            $stub_path = $path . $suite_name.'_db.sqlite';
            if( ! File::exists($stub_path)){
                File::put($stub_path, '');
            }
            Artisan::call('migrate', [
                '--database' => $suite_name,
                '--env' => 'testing'
            ]);
            Artisan::call('db:seed', [
                '--class' => $class_name,
                '--database' => $suite_name,
                '--env' => 'testing'
            ]);
        }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
//			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
//			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
