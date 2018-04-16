<?php

class autoloader {

    static public function library($dir) {
        $pattern = sprintf('%s/*', $dir);
        $files = glob($pattern);
        foreach ($files as $library_file) {
            require_once($library_file);
        }
    }

}
