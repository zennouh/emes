<?php

spl_autoload_register(function ($className) {
    echo $className;
    require_once $className . ".php";
});