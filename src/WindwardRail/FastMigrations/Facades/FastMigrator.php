<?php namespace WindwardRail\FastMigrations\Facades;

use Illuminate\Support\Facades\Facade;

class FastMigrator extends Facade {

    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FastMigrator';
    }

}