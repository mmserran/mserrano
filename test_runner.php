<?php

class test_runner {

    const valid_unittest = '/^unittests(\/[a-z_]+)+.test.php$/'; // the convention
    //
    const report_testname = 'AirPHP - test_runner';
    const report_destination = './tmp/php-coverage-report';
    const report_browser = 'google-chrome';

    protected $error;
    protected $filter;
    protected $coverage;

    public function __construct() {
        require_once('./vendor/autoload.php');
        require_once('./vendor/simpletest/simpletest/autorun.php');

        $this->error = false;
        $this->filter = new SebastianBergmann\CodeCoverage\Filter();
        $this->coverage = new SebastianBergmann\CodeCoverage\CodeCoverage(null, $this->filter);
    }

    public function __destruct() {
        $this->coverage->stop();
        $this->report_results();

        if ($this->error === false) {
            exec(sprintf('%s tmp/php-coverage-report/index.html', test_runner::report_browser));
        }
    }

    public function run_tests($dir) {
        $this->test_directory(rtrim($dir, '/'));
        $this->coverage->start(test_runner::report_testname);
    }

    public function report_results() {
        $writer = new SebastianBergmann\CodeCoverage\Report\Html\Facade();
        $writer->process($this->coverage, test_runner::report_destination);
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

    private function do_test_case($ut_filename) {
        if (preg_match(test_runner::valid_unittest, $ut_filename, $matches) && isset($matches[0]) === true) {
            $class = $this->load_class($ut_filename); // convention over configuration
            $this->coverage->filter()->addDirectoryToWhitelist($class);
        } else {
            $err_msg = sprintf('!! %s !! not following the convention', $ut_filename);
            error_log($err_msg);
            $this->error = true;
        }
    }

    private function load_class($ut_filename) {
        $path = explode('.', $ut_filename)[0];
        $list_path = explode('/', $path);
        $ut_dir = array_shift($list_path);
        $classname = array_pop($list_path);

        $utclass = sprintf('./%s/%s/%s.test.php', $ut_dir, join('/', $list_path), $classname);
        $class = sprintf('./%s/%s.php', join('/', $list_path), $classname);

        require_once($utclass);
        require_once($class);

        return $class;
    }

}

// --- run it ---
$src_dir = $argv[1]; // source directory for test files

$runner = new test_runner();
$runner->run_tests($src_dir);
