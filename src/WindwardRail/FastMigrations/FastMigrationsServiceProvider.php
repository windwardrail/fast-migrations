<?php namespace WindwardRail\FastMigrations;

use Artisan;
use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use WindwardRail\FastMigrations\Commands\RegenerateTestDBCommand;

class FastMigrationsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Bind the class used for the facade
		$this->app->bind('FastMigrator', function($app) {
			$db_path = Config::get('fast-migrations::config.db_path');
			$db_suffix = Config::get('fast-migrations::config.db_suffix');
			$target_db = Config::get('fast-migrations::config.target_db');

			return new DatabaseTransactor($db_path, $db_suffix, $target_db);
		});

		// Register the artisan command
		$this->app['command.fast-migrations.run'] = $this->app->share(function($app)
		{
			return new RegenerateTestDBCommand;
		});
		$this->commands(array('command.fast-migrations.run'));
	}

	public function boot() {
		$this->package('windward-rail/fast-migrations');

		// Register the Facade Alias
		AliasLoader::getInstance()->alias(
			'FastMigrator',
			'WindwardRail\FastMigrations\Facades\FastMigrator'
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['FastMigrator'];
	}
}
