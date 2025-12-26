<?php

namespace Menus;

use MethodHelpers\Enrichment;
use Exception;
use MethodHelpers\PrintMsg;
use Menus\Menu;
use PDO;
use Repo\ClubRepository;
use Repo\TeamRepository;
use Repo\TournamentRepository;
use Services\Container;

class CrudMenu extends Menu
{

    static function  crudMenu(string $title, $repo, string $type)
    {
        while (true) {
            parent::clearScreen();

            $options = [
                '1' => "View all $title",
                '2' => "Search by ID",
                '3' => "Create new " . rtrim($title, 's'),
                '4' => "Delete " . rtrim($title, 's'),
                '5' => "Back to Main Menu"
            ];

            parent::printMenu($options, strtoupper($title) . " MANAGEMENT");

            $choice =  parent::input("Select an option", true);

            parent::clearScreen();

            switch ($choice) {
                case '1':
                    self::listAll($repo, $title, $type);
                    break;
                case '2':
                    self::findById($repo, $title, $type);
                    break;
                case '3':
                    self::createEntity($repo, $type);
                    break;
                case '4':
                    self::deleteEntity($repo, $title, $type);
                    break;
                case '5':
                    return;
                default:
                    PrintMsg::printError("Invalid option. Please try again.");
                    PrintMsg::pause();
            }
        }
    }

    private static function listAll($repo, string $title, string $type)
    {
        parent::clearScreen();
        parent::printHeader("ALL " . strtoupper($title));

        try {
            $data = $repo->all();
            Enrichment::displayEnrichedData($data, $type);
        } catch (Exception $e) {
            PrintMsg::printError("Error in get data: " . $e->getMessage());
        }

        PrintMsg::pause();
    }

    private static  function findById($repo, string $title, string $type)
    {
        parent::clearScreen();
        parent::printHeader("SEARCH " . strtoupper(rtrim($title, 's')));

        $id = (int)   parent::input("Enter ID", true);

        try {
            $result = $repo->find($id);

            if ($result) {
                Enrichment::displayEnrichedData([$result], $type);
            } else {
                PrintMsg::printInfo("No " . rtrim($title, 's') . " found with ID: $id");
            }
        } catch (Exception $e) {
            PrintMsg::printError("Search failed: " . $e->getMessage());
        }

        PrintMsg::pause();
    }

    private static  function createEntity($repo, string $type)
    {
        parent::clearScreen();
        parent::printHeader("CREATE NEW " . strtoupper($type));

        try {
            switch ($type) {
                case 'club':
                    $name =   parent::input("Club Name", true);
                    $city =   parent::input("City", true);
                    $repo->create($name, $city);
                    break;

                case 'team':
                    $clubId = self::selectClub();
                    $name =   parent::input("Team Name", true);
                    $game =   parent::input("Game", true);
                    $repo->create($clubId, $name, $game);
                    break;

                case 'tournament':
                    $title =   parent::input("Tournament Title", true);
                    $cash = (int)   parent::input("Cash Prize ($)", true);
                    $format =   parent::input("Format (e.g., Single Elimination, Round Robin)", true);
                    $date =   parent::input("Date (YYYY-MM-DD HH:MM:SS)", true);
                    $repo->create($title, $cash, $format, $date);
                    break;

                case 'match':
                    $tournamentId = self::selectTournament();

                    echo "\n  \033[1;34m🎮 Team A:\033[0m";
                    $teamA = self::selectTeam();

                    echo "\n  \033[1;34m🎮 Team B:\033[0m";
                    $teamB = self::selectTeam();

                    $scoreA = (int)   parent::input("Team A Score", true);
                    $scoreB = (int)   parent::input("Team B Score", true);

                    $hasWinner =   parent::confirmAction("Has the match concluded with a winner?");
                    $winner = null;
                    if ($hasWinner) {
                        echo "\n  \033[1;35m🏆 Select Winner:\033[0m";
                        echo "\n    \033[33m[$teamA]\033[0m Team A";
                        echo "\n    \033[33m[$teamB]\033[0m Team B\n";
                        $winner = (int)   parent::input("Winner Team ID", true);
                    }

                    $format =   parent::input("Format (e.g., BO3, BO5)", true);
                    $date =   parent::input("Date (YYYY-MM-DD HH:MM:SS)", true);

                    $repo->create(
                        $scoreA,
                        $scoreB,
                        $tournamentId,
                        $teamA,
                        $teamB,
                        $winner,
                        $format,
                        $date
                    );
                    break;
            }

            PrintMsg::printSuccess(ucfirst($type) . " created successfully!");
        } catch (Exception $e) {
            PrintMsg::printError("Creation failed: " . $e->getMessage());
        }

        PrintMsg::pause();
    }

    private static function deleteEntity($repo, string $title, string $type)
    {
        parent::clearScreen();
        parent::printHeader("DELETE " . strtoupper(rtrim($title, 's')));

        $id = (int)   parent::input("Enter ID to delete", true);

        try {
            $record = $repo->find($id);

            if (!$record) {
                PrintMsg::printInfo("No " . rtrim($title, 's') . " found with ID: $id");
                PrintMsg::pause();
                return;
            }

            Enrichment::displayEnrichedData([$record], $type);

            if (parent::confirmAction("Are you sure you want to delete this record?")) {
                $repo->delete($id);
                PrintMsg::printSuccess("Record deleted successfully!");
            } else {
                PrintMsg::printInfo("Deletion cancelled.");
            }
        } catch (Exception $e) {
            PrintMsg::printError("Deletion failed: " . $e->getMessage());
        }

        PrintMsg::pause();
    }

    private static   function selectClub()
    {
        $clubRepo = Container::Instance()->get(ClubRepository::class);

        echo "\n  \033[1;35m📋 Available Clubs:\033[0m\n";
        $clubs = $clubRepo->all(PDO::FETCH_OBJ);

        $Ids = array_map(function ($c) {
            return $c->id;
        }, $clubs);

        foreach ($clubs as $club) {
            echo "    \033[33m[{$club->id}]\033[0m {$club->name} - {$club->city}\n";
        }
        $pickedId = (int) self::input("\n  Select Club ID", true);
        if (in_array($pickedId, $Ids)) {
            return $pickedId;
        } else {
            throw new Exception("Invalid id: $pickedId");
        }
    }

    private static   function selectTeam()
    {
        $teamRepo = Container::Instance()->get(TeamRepository::class);

        echo "\n  \033[1;35m📋 Available Teams:\033[0m\n";
        $teams = Enrichment::enrichTeamsData($teamRepo->all());

        foreach ($teams as $team) {
            echo "    \033[33m[{$team['id']}]\033[0m {$team['name']} ({$team['club_name']}) - {$team['game']}\n";
        }


        $Ids = array_map(function ($c) {
            return $c["id"];
        }, $teams);

        $pickedId = (int) self::input("\n  Select Team ID", true);
        if (in_array($pickedId, $Ids)) {
            return $pickedId;
        } else {

            throw new Exception("Invalid id: $pickedId");
        }
    }

    private static   function selectTournament()
    {
        $tournamentRepo = Container::Instance()->get(TournamentRepository::class);

        echo "\n  \033[1;35m📋 Available Tournaments:\033[0m\n";
        $tournaments = $tournamentRepo->all(PDO::FETCH_OBJ);

        foreach ($tournaments as $tournament) {
            echo "    \033[33m[{$tournament->id}]\033[0m {$tournament->title} - \${$tournament->cashPrize}\n";
        }


        $Ids = array_map(function ($c) {
            return $c->id;
        }, $tournaments);

        $pickedId = (int) self::input("\n  Select Tournament ID", true);
        if (in_array($pickedId, $Ids)) {
            return $pickedId;
        } else {
            // PrintMsg::printError("Invalid Id: $pickedId");
            throw new Exception("Invalid id: $pickedId");
        }
    }
}
