<?php namespace WindwardRail\FastMigrations;

use Config;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

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
		$this->app->bind('FastMigrator', function($app) {
			$db_path = Config::get('fast-migrations::config.db_path');
			$db_suffix = Config::get('fast-migrations::config.db_suffix');
			$target_db = Config::get('fast-migrations::config.target_db');

			return new DatabaseTransactor($db_path, $db_suffix, $target_db);
		});

	}

	public function boot() {
		$this->package('windward-rail/fast-migrations');

		AliasLoader::getInstance()->alias(
			'FastMigrator',
			'WindwardRail\FastMigrations\Facades\FastMigrator'
		);

		//Artisan::add(new RegenerateTestDBCommand);

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
