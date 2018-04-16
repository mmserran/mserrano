<?php

// load library files
$root = dirname(dirname(__FILE__));
$library = sprintf('%s/library/php', $root);
require(sprintf('%s/autoloader.php', $library));
autoloader::library($library);

// get midtier

    // collect get, post, files
    $input = new input($_GET, $_POST);

    $path = $_SERVER['REDIRECT_URL'];
    error_log(print_r($path, true));


    // build it

    // print it