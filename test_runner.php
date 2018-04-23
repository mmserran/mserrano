<?php
require_once('vendor/autoload.php');
require_once('library/php/autoloader.php');
autoloader::library(__DIR__);

$src_dir    = $argv[1]; // source directory for test files
$is_initial = $argv[2] ?? 0; // if present, will treat as descendent

$err_lines = array();
if ($is_initial === 0) {
    $arrows = style('cyan:blink', '>>>');
    $date   = style('cyan', date('Y-m-d H:i:s (g:i:s A e)'));

    echo sprintf('%1$s%1$s%2$s TEST RUN: %3$s%1$s%1$s', PHP_EOL, $arrows, $date);
    echo sprintf("%s%s", style('cyan', '+++'), PHP_EOL);
}
if (empty($src_dir) === false) {
    if (is_dir($src_dir) === true) {
        $pattern = sprintf('%s/*', rtrim($src_dir, '/'));
        $files   = glob($pattern);
        foreach ($files as $path) {
            do_command(sprintf('php test_runner.php %s -d %s', $path, '2>&1'));
        }
    } else {
        if ($is_initial === 0) {
            do_command(sprintf('php test_runner.php %s -d %s', $src_dir, '2>&1'));
        } else {
            $obj = new test_file($src_dir);
            $obj->run_test();
        }
    }
}
if ($is_initial === 0) {
    echo sprintf("%s%s", style('cyan', '+++'), PHP_EOL);
    foreach ($err_lines as $name => $err_lines) {
        $o_arrows = style('light_red', '>>>');
        $o_name   = style('bold:light_red', sprintf("%s", $name));
        $o_lines  = style('light_red', implode("\e[0m,\e[91m", $err_lines));
        echo sprintf("%s error on %s - line%s: %s%s", $o_arrows, $o_name, (count($err_lines) > 1 ? 's' : ''), $o_lines, PHP_EOL);
    }
}

class test_file {

    protected $ut_dir;
    protected $path;
    protected $name;
    //
    protected $ut_class;
    protected $class;
    protected $coverage;

    public function __construct($ut_file) {
        list($this->ut_dir, $this->path, $this->name) = $this->dissect_convention($ut_file);

        $this->ut_class = sprintf('%s/%s/%s.test.php', $this->ut_dir, $this->path, $this->name);
        $this->class    = sprintf('%s/%s.php', $this->path, $this->name);

        $this->coverage = new SebastianBergmann\CodeCoverage\CodeCoverage;
        $this->coverage->filter()->addDirectoryToWhitelist($this->class);
        $this->coverage->start($this->ut_class);
    }

    public function __destruct() {
        $this->coverage->stop();

        $this->output_report_to_terminal();
    }

    public function run_test() {
        require_once('./vendor/simpletest/simpletest/autorun.php');
        require_once($this->ut_class);
        require_once($this->class);
    }

    public function output_report_to_terminal() {
        $report = $this->coverage->getReport();
        $info   = array();
        foreach ($report as $item) {
            $classes = $item->getClassesAndTraits();
            foreach ($classes as $className => $class) {
                if ($className === $this->name) {
                    $count_missing = 0;
                    foreach ($class['methods'] as $method_name => $method_info) {
                        if ($method_info['coverage'] === 0) {
                            $count_missing += 1;
                        }
                    }
                    $info['missing']           = $count_missing;
                    $info['coverage']          = $class['coverage'];
                    $info['statements']        = $class['executableLines'];
                    $info['coveredstatements'] = $class['executedLines'];
                }
            }
        }
        $this->output_coverage_test($info);
    }

    private function dissect_convention($ut_path) {
        $info       = pathinfo($ut_path);
        $class_name = explode('.', $info['filename'])[0];

        $list_path = explode('/', $info['dirname']);
        $ut_dir    = array_shift($list_path);

        return array($ut_dir, join('/', $list_path), $class_name);
    }

    private function output_coverage_test($info) {
        $o_path  = style('', sprintf('/%s/%s', $this->ut_dir, $this->path));
        $o_class = style('cyan', '/' . sprintf('%s.test.php', $this->name));
        $o_stmt  = style('blue:light_gray_bg', sprintf('%.2f%%', $info['coverage']));
        if ($info['missing'] > 0) {
            $o_untested = sprintf(" - %s method%s untested !!", style('bold', $info['missing']), ($info['missing'] > 1 ? 's' : ''));
        }
        echo sprintf('%s%s: %s%s%s', $o_path, $o_class, $o_stmt, $o_untested ?? '', PHP_EOL);
    }

}

// --- helpers ---
function do_command($cmd) {
    $output = array();
    exec($cmd, $output); // 0=stdin, 1=stdout, 2=stderr or check /usr/include/unistd.h
    foreach ($output as $line) {
        $pattern = '/test_runner.php|OK|FAILURES!!!|Test cases run:.+/';
        if (preg_match($pattern, $line) === 0) {
            echo sprintf('%s %s', $line, PHP_EOL);
        }
        if (preg_match('/(\/[a-z_\.]+\.php) line ([0-9]+)]/', $line, $matches) !== 0) {
            $name        = $matches[1];
            $line_number = $matches[2];

            if (isset($err_lines[$name]) === false) {
                $err_lines[$name] = array();
            }
            $err_lines[$name][] = $line_number;
        }
    }
}

function style($rules, $string) {
    $list_rule          = explode(':', $rules);
    $common_color_codes = array(
        'bold'          => '1',
        'blink'         => '5',
        'inverted'      => '7',
        //
        'yellow'        => '33',
        'blue'          => '34',
        'cyan'          => '36',
        'light_red'     => '91',
        'light_cyan'    => '96',
        //
        'light_gray_bg' => '47',
    );

    $return = "";
    $tail   = "";
    foreach ($list_rule as $rule) {
        if (isset($common_color_codes[$rule]) === true) {
            $return .= sprintf("\e[%sm", $common_color_codes[$rule]);
            $tail   .= "\e[0m";
        }
    }
    return sprintf("%s%s%s", $return, $string, $tail);
}
