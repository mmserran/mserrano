<?php

class outputTest extends UnitTestCase {

    public $rnd;

    function setUp() {
        $this->rnd = random_int(0, 200);
    }

    function tearDown() {
        
    }

    function test___construct() {
        $obj = new output();
        $res = helper_ut::val($obj, 'headers');

        $this->assertEqual(array(), $res);
    }

    function test_print_it() {
        
    }

    function test_add_header() {
        $obj = new output();
        $exp = 'Content-type: javascript/' . ($this->rnd + 0);
        $obj->add_header($exp);
        $res = helper_ut::val($obj, 'headers');

        if ($this->assertEqual(count($res), 1, 'headers broken') === true) {
            $this->assertEqual($exp, $res[0]);
        }
    }

    function test_format() {
        
    }

}
