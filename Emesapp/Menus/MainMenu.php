<?php

namespace Menus;

use ConnectDB;
use CrudMenu;
use EmesApp\PrintMsg;
use Repo\ClubRepository;
use Repo\TeamRepository;
use Repo\PlayerRepository;
use Repo\TournamentRepository;
use Repo\MatchRepository;

class MainMenu extends Menu
{
    private $clubRepo;
    private $teamRepo;
    private $playerRepo;
    private $tournamentRepo;
    private $matchRepo;


    public function __construct()
    {
        $this->clubRepo = new ClubRepository();
        $this->teamRepo = new TeamRepository();
        $this->playerRepo = new PlayerRepository();
        $this->tournamentRepo = new TournamentRepository();
        $this->matchRepo = new MatchRepository();
    }

    function mainMenu()
    {


        while (true) {
            parent::clearScreen();

            $options = [
                '1' => 'Tournaments Management',
                '2' => 'Clubs Management',
                '3' => 'Teams Management',
                '4' => 'Players Management',
                '5' => 'Matches Management',
                '6' => 'Reports & Statistics',
                '7' => 'Exit Application'
            ];

            parent::printMenu($options, "E-Sport Event Manager");

            $choice =  parent::input("Select an option", true);

            parent::clearScreen();

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
                    CrudMenu::crudMenu("Players", $this->playerRepo, 'player');
                    break;
                case '5':
                    CrudMenu::crudMenu("Matches", $this->matchRepo, 'match');
                    break;
                case '6':
                    ReportMenu::reportsMenu();
                    break;
                case '7':
                    parent::clearScreen();
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
