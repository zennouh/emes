<?php

namespace MethodHelpers;

use MethodHelpers\PrintMsg;
use Repo\ClubRepository;
use Repo\TeamRepository;
use Repo\TournamentRepository;
use Services\Container;

class Enrichment
{

    static function enrichTeamsData(array $teams)
    {
        $clubRepo = Container::Instance()->get(ClubRepository::class);

        $enriched = [];
        foreach ($teams as $team) {
            $teamArray = (array)$team;

            if (isset($teamArray['clubId'])) {
                $club = $clubRepo->find($teamArray['clubId']);
                if ($club) {
                    $clubData = (array)$club;
                    $teamArray['club_name'] = $clubData['name'] ?? 'Unknown';
                } else {
                    $teamArray['club_name'] = 'Unknown';
                }
            }

            $enriched[] = $teamArray;
        }

        return $enriched;
    }

    static    function enrichPlayersData(array $players)
    {
        $teamRepo = Container::Instance()->get(TeamRepository::class);
        $clubRepo = Container::Instance()->get(ClubRepository::class);

        $enriched = [];
        foreach ($players as $player) {
            $playerArray = (array)$player;

            if (isset($playerArray['teamId'])) {
                $team = $teamRepo->find($playerArray['teamId']);
                if ($team) {
                    $teamData = (array)$team;
                    $playerArray['team_name'] = $teamData['name'] ?? 'Unknown';

                    if (isset($teamData['clubId'])) {
                        $club = $clubRepo->find($teamData['clubId']);
                        if ($club) {
                            $clubData = (array)$club;
                            $playerArray['club_name'] = $clubData['name'] ?? 'Unknown';
                        } else {
                            $playerArray['club_name'] = 'Unknown';
                        }
                    }
                } else {
                    $playerArray['team_name'] = 'Unknown';
                }
            }

            $enriched[] = $playerArray;
        }

        return $enriched;
    }

    static  function enrichMatchesData(array $matches)
    {
        $container =  Container::Instance();
        $teamRepo = $container->get(TeamRepository::class);
        $tournamentRepo = $container->get(TournamentRepository::class);
        $enriched = [];
        foreach ($matches as $match) {
            $matchArray = (array)$match;

            if (isset($matchArray['team_a'])) {
                $teamA = $teamRepo->find($matchArray['team_a']);
                if ($teamA) {
                    $teamAData = (array)$teamA;
                    $matchArray['team_a_name'] = $teamAData['name'] ?? 'Unknown';
                } else {
                    $matchArray['team_a_name'] = 'Unknown';
                }
            }

            if (isset($matchArray['team_b'])) {
                $teamB = $teamRepo->find($matchArray['team_b']);
                if ($teamB) {
                    $teamBData = (array)$teamB;
                    $matchArray['team_b_name'] = $teamBData['name'] ?? 'Unknown';
                } else {
                    $matchArray['team_b_name'] = 'Unknown';
                }
            }

            if (isset($matchArray['winnerID']) && $matchArray['winnerID']) {
                $winner = $teamRepo->find($matchArray['winnerID']);
                if ($winner) {
                    $winnerData = (array)$winner;
                    $matchArray['winner_name'] = $winnerData['name'] ?? 'Unknown';
                } else {
                    $matchArray['winner_name'] = 'Unknown';
                }
            } else {
                $matchArray['winner_name'] = 'TBD';
            }

            if (isset($matchArray['tournamentId'])) {
                $tournament = $tournamentRepo->find($matchArray['tournamentId']);
                if ($tournament) {
                    $tournamentData = (array)$tournament;
                    $matchArray['tournament_name'] = $tournamentData['title'] ?? 'Unknown';
                } else {
                    $matchArray['tournament_name'] = 'Unknown';
                }
            }

            $enriched[] = $matchArray;
        }

        return $enriched;
    }

    static  function displayEnrichedData(array $data, string $type)
    {

        switch ($type) {
            case 'team':
                $enriched = self::enrichTeamsData($data);
                $headers = ['id', 'name', 'club_name', 'game', 'created_at'];
                break;

            case 'player':
                $enriched = self::enrichPlayersData($data);
                $headers = ['id', 'pseudo', 'team_name', 'club_name', 'role', 'salary', 'created_at'];
                break;

            case 'match':
                $enriched = self::enrichMatchesData($data);
                $headers = ['id', 'team_a_name', 'score_a', 'team_b_name', 'score_b', 'winner_name', 'tournament_name', 'format', 'date'];
                break;

            default:
                PrintMsg::printTable($data);
                return;
        }

        $filtered = [];
        foreach ($enriched as $item) {
            $row = [];
            foreach ($headers as $header) {
                if (isset($item[$header])) {
                    $row[$header] = $item[$header];
                }
            }
            $filtered[] = $row;
        }

        PrintMsg::printTable($filtered, $headers);
    }
}
