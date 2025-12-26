<?php

// use EmesApp\PrintMsg;

use MethodHelpers\PrintMsg;


spl_autoload_register(function ($className) {
    $className = str_replace("\\", "/", $className);
    require_once "./" . $className . ".php";
});



try {
    $kernel = new Kernel();
    $kernel->handler();
} catch (Exception $e) {
    PrintMsg::printError("error: " . $e->getMessage());

    exit(1);
}
