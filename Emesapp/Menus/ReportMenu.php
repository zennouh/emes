<?php

namespace Menus;

use EmesApp\PrintMsg;
use Menus\Menu;

class ReportMenu extends Menu
{


   static function reportsMenu()
    {
        while (true) {
            parent::clearScreen();

            $options = [
                '1' => 'Club Statistics',
                '2' => 'Team Rankings',
                '3' => 'Player Salary Report',
                '4' => 'Tournament Overview',
                '5' => 'Match History',
                '6' => 'Back to Main Menu'
            ];

            parent::printMenu($options, "REPORTS & STATISTICS");

            $choice =  parent::input("Select an option", true);

            parent::clearScreen();

            switch ($choice) {
                case '1':
                case '2':
                case '3':
                case '4':
                case '5':
                    PrintMsg::printInfo("This report feature is coming soon!");
                    PrintMsg::pause();
                    break;
                case '6':
                    return;
                default:
                    PrintMsg::printError("Invalid option. Please try again.");
                    PrintMsg::pause();
            }
        }
    }
}
