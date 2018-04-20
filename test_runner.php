<?php

class test_runner {

    const valid_unittest = '/^unittests(\/[a-z_]+)+\.test\.php$/';
    //
    const report_testname = 'mserrano - test_runner';
    const report_destination = './tmp/php-coverage-report';
    const report_browser = 'google-chrome';

    protected $coverage;
    protected $error;
    protected $test_count;

    public function __construct() {
        require_once('./vendor/autoload.php');
        require_once('./vendor/simpletest/simpletest/autorun.php');

        $filter = new SebastianBergmann\CodeCoverage\Filter();
        $this->coverage = new SebastianBergmann\CodeCoverage\CodeCoverage(null, $filter);
        $this->error = null;
        $this->test_count = 0;
    }

    public function __destruct() {
        $this->coverage->stop();

        if (is_null($this->error) === true) {
            $this->report_results();
            exec(sprintf('%s tmp/php-coverage-report/index.html', test_runner::report_browser));
        } else {
            $this->raise_error();
        }
    }

    public function run_tests($arg) {
        $dir = rtrim($arg, '/');
        $this->whitelist_corresponding($dir);
        $this->test_directory($dir);
        $this->coverage->start(test_runner::report_testname);

        if ($this->test_count === 0) {
            $this->error = array(
                'file' => 'NO TESTS',
                'msg' => 'none or all invalid',
                'exclamation' => "\e[91m...\e[0m \e[1m(╯°□°）╯\e[0m\e[96m\e[5m=====)\e[0m\e[0m \e[33m┻━┻\e[0m",
            );
        }
    }

    // --- functions ---
    protected function report_results() {
        $writer = new SebastianBergmann\CodeCoverage\Report\Html\Facade();
        $writer->process($this->coverage, test_runner::report_destination);
    }

    protected function whitelist_corresponding($ut_root) {
        $is_subdir = (count(explode('/', $ut_root)) !== 1);

        $files = glob(sprintf('%s/*', $ut_root));
        if ($is_subdir === true) {
            $actual_dir = $this->strip_ut_dir($ut_root);
            $this->traverse_directory($actual_dir, array($this, 'do_whitelist'));
        } else {
            foreach ($files as $path) {
                if (is_dir($path) === true) {
                    $actual_dir = $this->strip_ut_dir($path);
                    $this->traverse_directory($actual_dir, array($this, 'do_whitelist'));
                } else {
                    $this->do_whitelist($path);
                }
            }
        }
    }

    protected function test_directory($dir) {
        $this->traverse_directory($dir, array($this, 'do_test_case'));
    }

    protected function raise_error() {
        $file = sprintf("\e[91m!! \e[7m%s\e[0m \e[91m!!\e[0m", $this->error['file']);
        $msg = sprintf("\e[91m%s\e[0m", $this->error['msg']);
        $exclamation = sprintf("%s", $this->error['exclamation']);

        echo sprintf("%s %s%s%s", $file, $msg, $exclamation, PHP_EOL);
    }

    // --- helpers ---
    private function strip_ut_dir($path) {
        $list_path = explode('/', $path);
        array_shift($list_path);

        return implode('/', $list_path);
    }

    private function traverse_directory($dir, $function) {
        $files = glob(sprintf('%s/*', $dir));
        foreach ($files as $path) {
            if (is_dir($path) === true) {
                $this->traverse_directory($path, $function);
            } else {
                call_user_func($function, $path);
            }
        }
    }

    private function do_whitelist($path) {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if ($extension === 'php') {
            $class = sprintf('./%s', $path);
            $this->coverage->filter()->addDirectoryToWhitelist($class);
        }
    }

    private function do_test_case($ut_filename) {
        $path = explode('.', $ut_filename)[0];
        $list_path = explode('/', $path);
        $ut_dir = array_shift($list_path);
        $classname = array_pop($list_path);

        $utclass = sprintf('./%s/%s/%s.test.php', $ut_dir, join('/', $list_path), $classname);
        $class = sprintf('./%s/%s.php', join('/', $list_path), $classname);

        $continue = true;
        $continue = $continue && (preg_match(test_runner::valid_unittest, $ut_filename, $matches));
        $continue = $continue && (empty($matches[0]) === false); // matched the full pattern
        $continue = $continue && (file_exists($class) === true);
        $continue = $continue && (file_exists($utclass) === true);

        if ($continue === true) {
            require_once($class);
            require_once($utclass);

            $this->test_count += 1;
        } else {
            $this->error = array(
                'file' => $ut_filename,
                'msg' => 'no corresponding class found',
                'exclamation' => "\e[91m...\e[0m \e[1m(╯°□°）╯\e[0m\e[96m\e[5m︵ \e[0m\e[0m \e[33m┻━┻\e[0m",
            );
        }
    }

}

// --- run it ---
$src_dir = $argv[1]; // source directory for test files

$runner = new test_runner();
$runner->run_tests($src_dir);
