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
     * @var FileDriver
     */
    private $fileDriver;

    /**
     * @param string $db_path
     * @param string $db_suffix
     * @param string $target_db
     * @param FileDriver $fileDriver
     */
    public function __construct($db_path, $db_suffix, $target_db, FileDriver $fileDriver) {
        $this->db_path = $db_path;
        $this->db_suffix = $db_suffix . '.sqlite';
        $this->target_db = $target_db . '.sqlite';
        $this->fileDriver = $fileDriver;
    }

    /**
     * Migrate the database for the given test suite by overwriting the target database file with the stored version.
     *
     * @param string $suite_name
     */
    public function migrate($suite_name = 'empty') {
        $source_db_path = $this->db_path . $suite_name . $this->db_suffix;

        if($this->fileDriver->exists($source_db_path)){
            $this->fileDriver->copy( $source_db_path,  $this->db_path . $this->target_db);
        }
    }
}
