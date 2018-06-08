<?php

class sanitizer_config {

    protected $options;

    public function __construct() {
        $this->options = array(
            'set' => array(),
        );
    }

    public function register_set($set_name, $unknown, $type) {
        $this->options['set'][$set_name] = $this->__transform($unknown, $type);
    }

    public function list_dataset() {
        return $this->options['set'];
    }

    // --- helpers ---
    private function __transform($data, $type): array {
        $return = null;
        switch ($type) {
            case cst_sanitizer::type_json:
                $return = json_decode($data, true);
                break;
            case cst_sanitizer::type_query:
                $return = urldecode($data);
                break;
            case cst_sanitizer::type_php:
                $return = $data;
                break;
        }
        return $return;
    }

}
