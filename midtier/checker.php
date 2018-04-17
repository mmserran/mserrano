<?php

class checker extends page_base {

    public function build() {
        error_log(print_r(cst_infrastructure::result, true));
        error_log(print_r($this->get, true));
        error_log(print_r($this->post, true));
    }

}
