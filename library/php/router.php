<?php

class router {

    const valid_page = '/^(\/[a-z]+)+$/';

    static public function get_page() {
        $return = null;

        $path = $_SERVER['REDIRECT_URL'];
        if (preg_match(router::valid_page, $path, $matches) && isset($matches[0]) === true) {
            $return = 1;
        }
        return $return;
    }

    // --- helpers ---
}
