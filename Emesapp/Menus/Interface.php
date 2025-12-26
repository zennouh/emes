<?php

namespace Menus;

interface MenuMainFunctions
{
    static  function clearScreen();
    static function printHeader(string $title);
    static  function confirmAction(string $message): bool;
    static  function input(string $label, bool $required = true): string;
     static function printMenu(array $options, string $title = "MENU");
}
