<?php

namespace Menus;

use MethodHelpers\PrintMsg;

abstract class  Menu implements MenuMainFunctions
{

    static function printHeader(string $title)
    {
        $width = 50;
        $padding = ($width - strlen($title) - 2) / 2;

        echo "\n" . str_repeat(" ", $width) . "\n";
        echo  " $title " . str_repeat(" ", ceil($padding)) . "\n";
        echo "\n";
    }

    static function printMenu(array $options, string $title = "MENU")
    {
        self::printHeader($title);

        foreach ($options as $key => $label) {
            echo "  \033[1;33m$key.\033[0m $label\n";
        }

        echo "\n  " . str_repeat("─", 45) . "\n";
    }


    static  function input(string $label, bool $required = true): string
    {
        do {
            echo "  \033[36m▶\033[0m $label: ";
            $value = trim(fgets(STDIN));

            if (!$required || !empty($value)) {
                return $value;
            }

            echo "  \033[31m✗ This field is required!\033[0m\n";
        } while (true);
    }

    static  function confirmAction(string $message): bool
    {
        echo "\n  \033[1;33m⚠ $message (y/n):\033[0m ";
        $response = strtolower(trim(fgets(STDIN)));
        return in_array($response, ['y', 'yes']);
    }

    static  function clearScreen()
    {
        echo "\033[2J\033[H";
    }
}
