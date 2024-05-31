<?php

spl_autoload_register(function ($class_name) {
    include 'siniflar/' . $class_name . '.php';
});

?>