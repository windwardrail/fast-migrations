<?php namespace WindwardRail\FastMigrations;

use File;

class DatabaseTransactor {
    /**
     * The path used for database storage

     * @var string
     */
    protected $db_path;

    /**
     * Suffix appended to stored databases
     *
     * @var string
     */
    protected $db_suffix;

    /**
     * Temp file to be used as database stand in
     *
     * @var string
     */
    protected $target_db;

    /**
     * @param string $db_path
     * @param string $db_suffix
     * @param string $target_db
     */
    public function __construct($db_path, $db_suffix, $target_db) {
        $this->db_path = $db_path;
        $this->db_suffix = $db_suffix . '.sqlite';
        $this->target_db = $target_db . '.sqlite';
    }

    /**
     * Migrate the database for the given test suite by overwriting the target database file with the stored version.
     *
     * @param string $suite_name
     */
    public function migrate($suite_name = 'empty') {
        $db_path = app_path() . $this->db_path;
        $source_db_path = $db_path . $suite_name . $this->db_suffix;

        if(File::exists($source_db_path)){
            File::copy( $source_db_path,  $db_path . $this->target_db);
        }
    }
}
