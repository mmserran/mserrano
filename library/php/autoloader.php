<?php

class autoloader {

    const max_depth = 1;

    static public function library($dir) {
        $main_dir = sprintf('%s/*', $dir);
        autoloader::load_dir($main_dir);
    }

    // --- helpers ---
    static private function load_dir($to_glob, $depth = 0) {
        $files = glob($to_glob);
        foreach ($files as $lib_file) {
            if (is_dir($lib_file) === true) {
                $subdir_pattern = autoloader::get_subdir_pattern($lib_file);
                autoloader::load_dir($subdir_pattern, ($depth + 1));
            } else if ($depth <= autoloader::max_depth) {
                require_once($lib_file);
            }
        }
    }

    static private function get_subdir_pattern($lib_file) {
        $tag = explode('/', $lib_file);
        $tag = substr(end($tag), 0, -1);
        $subdir_pattern = sprintf('%s/%s_*', $lib_file, $tag);

        return $subdir_pattern;
    }

}
