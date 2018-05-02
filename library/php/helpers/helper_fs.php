<?php

// Intended as helper class for UNIT TESTING
class helper_fs {

    static public function blacklist() {
        return ['silent_autorun.php', 'test_runner.php', 'test_coverage.php'];
    }

    static public function project_root() {
        $path = explode('/library', __DIR__);
        return $path[0];
    }

}
