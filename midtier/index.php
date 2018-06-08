<?php

class index extends page_base {

    public function build(output $output) {
        $app_name       = cst_infrastructure::app_name;
        $default_layout = sprintf('%s/index.html', __DIR__);
        $template       = file_get_contents($default_layout);

        $args    = array(
            'js'    => sprintf('%s.mserrano.%s.js', $app_name, $this->uniq_fingerprint($app_name . '.mserrano.js')),
            'css'   => sprintf('%s.mserrano.%s.css', $app_name, $this->uniq_fingerprint($app_name . '.mserrano.css')),
            'const' => sprintf('/%s_constants', $app_name),
            'app'   => $app_name,
        );
        $replace = array(
            '%_MSERRANO-DEV_%' => sprintf('/apploader.min.js?%s', http_build_query($args)),
            '%_VENDOR-CSS_%'   => $this->uniq_fingerprint('vendor.mserrano.css'),
            '%_VENDOR-JS_%'    => $this->uniq_fingerprint('vendor.mserrano.js'),
        );

        $this->response = str_replace(
                array_keys($replace), array_values($replace), $template
        );
        $output->format($this->response, output::html);
    }

    private function fullpath($file) {
        return sprintf('%s/%s', __DIR__, $file);
    }

    private function uniq_fingerprint($file) {
        $public_path = sprintf('../public/%s', $file);
        // cache busting: use the middle 10 digits of its sha1 hash
        return substr(sha1_file($this->fullpath($public_path)), 15, 10);
    }

}
