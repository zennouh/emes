<?php

namespace Menus;


use MethodHelpers\PrintMsg;
use Repo\ClubRepository;
use Repo\TeamRepository;
use Repo\TournamentRepository;
use Repo\MatchRepository;

class MainMenu extends Menu
{
    private $clubRepo;
    private $teamRepo;
    private $tournamentRepo;
    private $matchRepo;


    public function __construct()
    {
        $this->clubRepo = new ClubRepository();
        $this->teamRepo = new TeamRepository();
        $this->tournamentRepo = new TournamentRepository();
        $this->matchRepo = new MatchRepository();
        echo "constfyt";
    }

    function mainMenu()
    {


        while (true) {
            $this->clearScreen();

            $options = [
                '1' => 'Tournaments Management',
                '2' => 'Clubs Management',
                '3' => 'Teams Management',
                '4' => 'Matches Management',
                '5' => 'Reports & Statistics',
                '6' => 'Exit Application'
            ];

            $this->printMenu($options, "E-Sport Event Manager");

            $choice =  $this->input("Select an option", true);

            $this->clearScreen();

            switch ($choice) {
                case '1':
                    CrudMenu::crudMenu("Tournaments", $this->tournamentRepo, 'tournament');
                    break;
                case '2':
                    CrudMenu::crudMenu("Clubs", $this->clubRepo, 'club');
                    break;
                case '3':
                    CrudMenu::crudMenu("Teams", $this->teamRepo, 'team');
                    break;
                case '4':
                    CrudMenu::crudMenu("Matches", $this->matchRepo, 'match');
                    break;
                case '5':
                    StatisticMenu::reportsMenu();
                    break;
                case '6':
                    $this->clearScreen();
                    PrintMsg::printSuccess("Thank you!");
                    echo "\n  \033[1;35m Goodbye!\033[0m\n\n";
                    exit(0);
                default:
                    PrintMsg::printError("Invalid option. Please try again.");
                    PrintMsg::pause();
            }
        }
    }
}
