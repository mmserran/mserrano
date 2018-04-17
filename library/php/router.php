<?php

class router {

    const valid_page = '/^(\/[a-z_]+)+$/';

    static public function get_page($root) {
        $return = null;

        $path = $_SERVER['REDIRECT_URL'];
        if (preg_match(router::valid_page, $path, $matches) && isset($matches[0]) === true) {
            $class_filepath = sprintf('%s/midtier%s.php', $root, $path);
            require($class_filepath);

            $full_path = explode('/', $path);
            $class_name = end($full_path);

            if (class_exists($class_name) === true) {
                $instance = new $class_name();
                if (is_a($instance, 'page_base') === true) {
                    $return = $instance;
                }
            }
        }
        return $return;
    }

    // --- helpers ---
}
