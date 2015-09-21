<?php namespace WindwardRail\FastMigrations;

use File;

class IlluminateFileDriver implements FileDriver {

    public function exists($file_path) {
        File::exists($file_path);
    }

    public function copy($source_path, $dest_path) {
        File::copy($source_path, $dest_path);
    }
}
