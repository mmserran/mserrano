<?php

class inputTest extends UnitTestCase {

    function setUp() {
        error_log(print_r('input test', true));
    }

    function tearDown() {
        
    }
    
    function test_data() {
        $obj = new input('get', 'post');
    }

}
