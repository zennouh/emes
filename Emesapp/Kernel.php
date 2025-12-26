
<?php

use Services\Container;
use Menus\MainMenu;
use Repo\ClubRepository;
use Repo\MatchRepository;
use Repo\TeamRepository;
use Repo\TournamentRepository;

class Kernel
{

    public function __construct()
    {
        $this->register();
    }

    public function register()
    {
        Container::Instance()->bind(ClubRepository::class, function ($container) {
            return new ClubRepository();
        }); 
        Container::Instance()->bind(MatchRepository::class, function ($container) {
            return new MatchRepository();
        });
        Container::Instance()->bind(TeamRepository::class, function ($container) {
            return new TeamRepository();
        });
        Container::Instance()->bind(TournamentRepository::class, function ($container) {
            return new TournamentRepository();
        });
    }

    public function handler()
    {
        $mainMenu = new MainMenu();
        $mainMenu->mainMenu();
    }
}
