<?php

class sanitizer_value {

    private $suspect_set;
    private $suspect_id;
    private $sane_type;
    private $default;
    private $result;

    public function __construct($set_name, $suspect_id, $sane_type, $default) {
        $this->suspect_set = $set_name;
        $this->suspect_id  = $suspect_id;
        $this->sane_type   = $sane_type;
        $this->default     = $default;
        $this->result      = cst_sanitizer::is_dangerous;
    }

    // --- functions ---
    public function get_safe($dangerous) {
        $dangerous_data = $dangerous[$this->suspect_set];
        $this->result   = sanitizer_core::defaulted($dangerous_data, $this->suspect_id, $this->sane_type, $this->default);

        return $this->result;
    }

    public function is_safe() {
        return ($this->result !== cst_sanitizer::is_dangerous);
    }

    public function name() {
        return $this->suspect_set;
    }

    public function key() {
        return $this->suspect_id;
    }

}
