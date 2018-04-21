<?php

class test_runner {

    const valid_unittest = '/^unittests(\/[a-z_]+)+\.test\.php$/'; // the convention
    //
    const report_testname = 'mserrano - test_runner';
    const report_dest_html = './tmp/php-coverage-report';
    const report_dest_xml = './tmp/php-coverage-report/index.xml';
    const report_browser = 'google-chrome';

    protected $coverage;
    protected $error;
    protected $test_count;
    protected $silent;

    public function __construct($silent) {
        require_once('./vendor/autoload.php');
        require_once('./vendor/simpletest/simpletest/autorun.php');

        $filter = new SebastianBergmann\CodeCoverage\Filter();
        $this->coverage = new SebastianBergmann\CodeCoverage\CodeCoverage(null, $filter);
        $this->error = null;
        $this->test_count = 0;
        $this->silent = (empty($silent) == false);
    }

    public function __destruct() {
        $this->coverage->stop();

        if (is_null($this->error) === true) {
            $this->create_coverage_report();
            $this->open_report_in_browser();
            $this->open_report_in_terminal();
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
    protected function create_coverage_report() {
        $writer = new SebastianBergmann\CodeCoverage\Report\Html\Facade();
        $writer->process($this->coverage, test_runner::report_dest_html);

        $writer = new SebastianBergmann\CodeCoverage\Report\Clover();
        $writer->process($this->coverage, test_runner::report_dest_xml);
    }

    protected function open_report_in_browser() {
        if ($this->silent === false) {
            exec(sprintf('%s tmp/php-coverage-report/index.html', test_runner::report_browser));
        }
    }

    private function open_report_in_terminal() {
        $xml_file = file_get_contents(test_runner::report_dest_xml);
        $report = simplexml_load_string($xml_file);

        echo sprintf("\e[36m%s\e[0m %s", '+++', PHP_EOL);

        $total = array(
            'covered' => 0,
            'statement' => 0,
            'stat' => 0,
        );
        foreach ($report->project as $obj) {
            foreach ($obj->file as $file_info) {
                $info = array(
                    'file' => (string) $file_info->attributes()->name,
                    'methods' => (integer) $file_info->metrics->attributes()->methods,
                    'coveredmethods' => (integer) $file_info->metrics->attributes()->coveredmethods,
                    'conditionals' => (integer) $file_info->metrics->attributes()->conditionals,
                    'coveredconditionals' => (integer) $file_info->metrics->attributes()->coveredconditionals,
                    'statements' => (integer) $file_info->metrics->attributes()->statements,
                    'coveredstatements' => (integer) $file_info->metrics->attributes()->coveredstatements,
                );

                $list_path = explode('/', $info['file']);
                $class_name = array_pop($list_path);
                $path = sprintf('%s', implode('/', $list_path));
                $statements = '';
                if ($info['statements'] !== 0) {
                    $stmt_coverage = (($info['coveredstatements'] / $info['statements']) * 100);
                    $statements = sprintf('%.2f%%', $stmt_coverage);

                    $total['statement'] += $info['statements'];
                    $total['covered'] += $info['coveredstatements'];
                }
                $methods = '';
                $count_missing = '';
                if ($info['methods'] > $info['coveredmethods'] === true) {
                    $count_missing = ($info['methods'] - $info['coveredmethods']);
                    $methods = sprintf(' method%s untested !!', ($count_missing > 1 ? 's' : ''));
                }
                echo sprintf("%s\e[36m/%s\e[0m%s\e[47m\e[34m%s\e[0m\e[0m%s\e[1m%s\e[0m%s %s", $path, $class_name, ($statements === '' ? '' : ': '), $statements, ($count_missing > 0 ? ' - ' : ''), $count_missing, $methods, PHP_EOL);
            }
        }
        echo sprintf("\e[36m%s\e[0m %s", '+++', PHP_EOL);
        $total['stat'] = (($total['covered'] / $total['statement']) * 100);
        echo sprintf("\e[1mTotal Statement Coverage\e[0m: \e[47m\e[34m%.2f%%\e[0m\e[0m (%s/%s lines)\e[36m.\e[0m %s", $total['stat'], $total['covered'], $total['statement'], PHP_EOL);
    }

    protected function whitelist_corresponding($ut_root) {
        $is_subdir = (count(explode('/', $ut_root)) !== 1);
        if ($is_subdir === true) {
            $actual_dir = $this->strip_ut_dir($ut_root);
            if (is_dir($ut_root) === false) {
                // if file, test only that file
                list($ut_dir, $path, $classname) = $this->dissect_convention($ut_root);
                $actual_file = sprintf('%s/%s.php', $path, $classname);
                $this->do_whitelist($actual_file);
            } else {
                // if subdir of unittests, traverse it (the actual subdir)
                $this->traverse_directory($actual_dir, array($this, 'do_whitelist'));
            }
        } else {
            // foreach subdir in unittests, traverse the actual subdir
            $files = glob(sprintf('%s/*', $ut_root));
            foreach ($files as $path) {
                if (is_dir($path) === true) {
                    $actual_dir = $this->strip_ut_dir($path);
                    $this->traverse_directory($actual_dir, array($this, 'do_whitelist'));
                } else {
                    $this->do_whitelist($path); // for files at subdir root
                }
            }
        }
    }

    protected function test_directory($dir) {
        if (is_dir($dir) === true) {
            $this->traverse_directory($dir, array($this, 'do_test_case'));
        } else {
            $this->do_test_case($dir); // single file
        }
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

        return sprintf('%s', implode('/', $list_path));
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
        list($ut_dir, $path, $classname) = $this->dissect_convention($ut_filename);

        $utclass = sprintf('./%s/%s/%s.test.php', $ut_dir, $path, $classname);
        $class = sprintf('./%s/%s.php', $path, $classname);

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

    private function dissect_convention($ut_filename) {
        $path = explode('.', $ut_filename)[0];
        $list_path = explode('/', $path);
        $ut_dir = array_shift($list_path);
        $classname = array_pop($list_path);

        return array($ut_dir, join('/', $list_path), $classname);
    }

}

// --- run it ---
$msg = sprintf("%s%s\e[5m\e[36m%s\e[0m\e[0mTEST RUN:", PHP_EOL, PHP_EOL, '>>> ');
echo sprintf("%s \e[36m%s\e[0m %s%s", $msg, date('Y-m-d H:i:s (g:i:s e)'), PHP_EOL, PHP_EOL);

$src_dir = $argv[1]; // source directory for test files
$silent_run = $argv[2]; // will not open browser if present

$runner = new test_runner($silent_run);
$runner->run_tests($src_dir);
