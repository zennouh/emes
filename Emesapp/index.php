<?php

use EmesApp\PrintMsg;
use Menus\MainMenu;

spl_autoload_register(function ($className) {
    echo $className . "\n";
    require_once $className . ".php";
});



try {
    $mainMenu = new MainMenu();
    $mainMenu->mainMenu();
} catch (Exception $e) {
    PrintMsg::printError("error: " . $e->getMessage());
    exit(1);
}
