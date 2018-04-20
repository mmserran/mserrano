<?php

class autoloaderTest extends UnitTestCase {

    function setUp() {
        error_log(print_r('why not', true));
    }

    function tearDown() {
        
    }

    function test_library() {
        $root = dirname(dirname(dirname(dirname(__FILE__))));
        autoloader::library($root);
        $this->assertTrue(true);
    }

}
