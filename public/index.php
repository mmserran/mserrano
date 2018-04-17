<?php

// load library files
$root = dirname(dirname(__FILE__));
$library = sprintf('%s/library/php', $root);
require(sprintf('%s/autoloader.php', $library));
autoloader::library($library);

// get midtier
$midtier = router::get_page();
if(is_null($midtier) === false) {
    // collect get, post, files
    $input = new input($_GET, $_POST);

    // build it

    // print it
}