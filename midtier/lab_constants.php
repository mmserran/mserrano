<?php

class lab_constants extends page_base {

    public function build(output $output) {
        $this->response = $this->setup_constants();
        $output->format($this->response, output::angular);
    }

    // --- helpers ---
    private function setup_constants() {
        $return = array(
            'Default' => array(
                'Date' => date('Y-m-d'),
            ),
        );
        return $return;
    }

}
