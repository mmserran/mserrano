<?php
// load library files
$root = dirname(dirname(__FILE__));
require(sprintf('%s/library/php/autoloader.php', $root));
autoloader::library($root);

// get midtier
$midtier = router::get_page($root);
if (is_null($midtier) === false) {
    // collect get, post, files
    $input = new input($_GET, file_get_contents("php://input"));
    $midtier->register_input($input);

    // build it
    $output = new output();
    $midtier->build($output);

    // print it
    $output->print_it();
}