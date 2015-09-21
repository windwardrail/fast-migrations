<?php namespace WindwardRail\FastMigrations;

interface FileDriver {
    public function exists($file_path);

    public function copy($source_path, $dest_path);
}
