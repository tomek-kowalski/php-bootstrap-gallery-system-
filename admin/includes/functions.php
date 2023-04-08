<?php

function  myAutoload($class) {

    $class= strtolower($class);
    $the_path = "includes/{$class}.php" ;

    if(is_file($the_path) && !class_exists($class))  {
        require_once($the_path);
    } else  {
        die("This file named {$the_path} was not found");
    }

}

spl_autoload_register('myAutoload');

function redirect($location) {

    header("Location:{$location}");

}

?>
