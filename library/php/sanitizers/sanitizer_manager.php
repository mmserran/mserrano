<?php

class sanitizer_manager {

    private $settings;
    private $sanitized;
    private $list_dangerous;

    public function __construct(sanitizer_config $options) {
        $this->to_sanitize = array();
        $this->settings    = array(
            'data' => $options->list_dataset(),
        );
    }

    public function run_it(): bool {
        $this->sanitized = array();

        $return = true;
        foreach ($this->list_dangerous as $sanitizer_value) {
            $set_name  = $sanitizer_value->name();
            $key       = $sanitizer_value->key();
            $dangerous = $this->settings['data'];

            // run sanitization via php filter
            $this->sanitized[$set_name][$key] = $sanitizer_value->get_safe($dangerous);

            $return = $return && ($sanitizer_value->is_safe() === true);
        }
        return $return;
    }

    public function get($set_name, $key) {
        return $this->sanitized[$set_name][$key];
    }

    public function queue_w_default($set_name, $suspect_id, $sane_type, $default) {
        // If fail, run_it will pass, result will be default
        $this->list_dangerous[] = new sanitizer_value($set_name, $suspect_id, $sane_type, $default);
    }

    public function queue_item($set_name, $suspect_id, $sane_type) {
        // If fail, run_it will fail, result will be null
        $this->queue_w_default($set_name, $suspect_id, $sane_type, cst_sanitizer::is_dangerous);
    }

}
