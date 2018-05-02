<?php

class helper_fsTest extends UnitTestCase {

    public $rnd;

    function setUp() {
        $this->rnd = random_int(0, 200);
    }

    function tearDown() {
        
    }

    function test_blacklist() {
        $obj = helper_fs::blacklist();
        $res = (is_array($obj) === true);
        $this->assertTrue($res);
    }

    function test_project_root() {
        $root = helper_fs::project_root();
        $res  = glob(sprintf('%s/*', $root));

        $exp = sprintf('%s/library', $root);
        $this->assertTrue(in_array($exp, $res));

        $exp = sprintf('%s/unittests', $root);
        $this->assertTrue(in_array($exp, $res));

        $exp = sprintf('%s/frontend', $root);
        $this->assertTrue(in_array($exp, $res));
    }

}
