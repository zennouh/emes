<?php

namespace Menus;

use EmesApp\PrintMsg;

abstract class  Menu
{

    function printMenu(array $options, string $title = "MENU")
    {
        PrintMsg::printHeader($title);

        foreach ($options as $key => $label) {
            $icon = $key === '0' || strpos($label, 'Back') !== false || strpos($label, 'Exit') !== false ? '←' : '•';
            echo "  \033[1;33m$key.\033[0m $icon $label\n";
        }

        echo "\n  " . str_repeat("─", 45) . "\n";
    }


    function input(string $label, bool $required = true): string
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

    function confirmAction(string $message): bool
    {
        echo "\n  \033[1;33m⚠ $message (y/n):\033[0m ";
        $response = strtolower(trim(fgets(STDIN)));
        return in_array($response, ['y', 'yes']);
    }

    function clearScreen()
    {
        echo "\033[2J\033[H";
    }
}
