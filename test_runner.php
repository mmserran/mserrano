<?php

class test_runner {

    protected $results;

    public function __construct() {
        require_once('./vendor/simpletest/simpletest/autorun.php');
    }

    public function run_tests($dir) {
        $this->test_directory(rtrim($dir, '/'));
    }

    public function report_results() {
        
    }

    // --- helpers ---

    private function test_directory($dir) {
        $files = glob(sprintf('%s/*', $dir));
        foreach ($files as $path) {
            if (is_dir($path) === true) {
                $this->test_directory($path);
            } else {
                $this->do_test_case($path);
            }
        }
    }

    private function do_test_case($path) {
        $name = explode('.', $path)[0];
        $name = explode('/', $name);
        $name = end($name);

        $class = sprintf('./unittests/library/php/%s.test.php', $name);
        require_once($class);
    }

}

// --- run it ---
$src_dir = $argv[1]; // source directory for test files

$runner = new test_runner();
$runner->run_tests($src_dir);
$runner->report_results();
