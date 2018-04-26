<?php

// Intended as helper class for UNIT TESTING
class helper_fs {

    static public function project_root() {
        $path = explode('/library', __DIR__);
        return $path[0];
    }

}
