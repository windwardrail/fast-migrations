<?php namespace WindwardRail\FastMigrations;

use File;

class DatabaseTransactor {
    protected $db_path;

    protected $db_suffix;

    protected $target_db;

    /**
     * DatabaseTransactor constructor.
     * @param string $db_path
     * @param string $db_suffix
     * @param string $target_db
     */
    public function __construct($db_path, $db_suffix, $target_db) {
        $this->db_path = $db_path;
        $this->db_suffix = $db_suffix . '.sqlite';
        $this->target_db = $target_db . '.sqlite';
    }

    public function migrate($suite_name = 'empty') {
        $db_path = app_path() . $this->db_path;
        $source_db_path = $db_path . $suite_name . $this->db_suffix;

        if(File::exists($source_db_path)){
            File::copy( $source_db_path,  $db_path . $this->target_db);
        }
    }
}