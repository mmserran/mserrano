<?php

class router {

    static public function get_page($root) {
        $return = null;

        $path = ($_GET[cst_infrastructure::page] ?? '');
        if (preg_match(cst_infrastructure::valid_page, $path, $matches) && isset($matches[0]) === true) {
            $class_name     = $matches[1];
            $class_filepath = router::get_filepath($root, $path);
            $return         = router::get_class_instance($class_filepath, $class_name);
        }
        if (is_null($return) === true) {
            $class_name     = 'index';
            $class_filepath = router::get_filepath($root, $class_name);
            $return         = router::get_class_instance($class_filepath, $class_name);
        }
        return $return;
    }

    // --- helpers ---
    static private function get_filepath($root, $path) {
        return sprintf('%s/midtier/%s.php', $root, $path);
    }

    static private function get_class_instance($class_filepath, $class_name) {
        $return = null;
        if (file_exists($class_filepath) === true) {
            require($class_filepath);

            if (class_exists($class_name) === true) {
                $instance = new $class_name();
                if (is_a($instance, 'page_base') === true) {
                    $return = $instance;
                }
            }
        }
        return $return;
    }

}
