<?php

namespace EmesApp;

abstract class PrintMsg
{
    static function pause()
    {
        echo "\n  \033[90m[Press ENTER to continue]\033[0m";
        fgets(STDIN);
    }

    static function printHeader(string $title)
    {
        $width = 50;
        $padding = ($width - strlen($title) - 2) / 2;

        echo "\n\033[1;44m" . str_repeat(" ", $width) . "\033[0m\n";
        echo "\033[1;44m" . str_repeat(" ", floor($padding)) . " $title " . str_repeat(" ", ceil($padding)) . "\033[0m\n";
        echo "\033[1;44m" . str_repeat(" ", $width) . "\033[0m\n\n";
    }

    static  function printSuccess(string $message)
    {
        echo "\n  \033[1;32m✓ $message\033[0m\n";
    }

    static  function printError(string $message)
    {
        echo "\n  \033[1;31m✗ $message\033[0m\n";
    }

    static  function printInfo(string $message)
    {
        echo "\n  \033[1;33mℹ $message\033[0m\n";
    }

    static  function printTable(array $data, array $headers = [])
    {
        if (empty($data)) {
            self::printInfo("No records found.");
            return;
        }

        if (empty($headers) && is_array($data[0])) {
            $headers = array_keys((array)$data[0]);
        }

        $widths = [];
        foreach ($headers as $header) {
            $widths[$header] = strlen($header);
        }

        foreach ($data as $row) {
            $row = (array)$row;
            foreach ($headers as $header) {
                $value = $row[$header] ?? '';
                $widths[$header] = max($widths[$header], strlen((string)$value));
            }
        }

        echo "\n  \033[1;36m";
        foreach ($headers as $header) {
            echo str_pad($header, $widths[$header] + 2);
        }
        echo "\033[0m\n";

        echo "  \033[90m" . str_repeat("─", array_sum($widths) + count($widths) * 2) . "\033[0m\n";

        foreach ($data as $row) {
            $row = (array)$row;
            echo "  ";
            foreach ($headers as $header) {
                $value = $row[$header] ?? '';
                echo str_pad($value, $widths[$header] + 2);
            }
            echo "\n";
        }
        echo "\n";
    }
}
