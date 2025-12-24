
<?php

use Core\Database\Migration\Column;
use Core\Database\Migration\Table;
use Core\ORM\Migration\Constrains\AutoIncrement;
use Core\ORM\Migration\Constrains\Id;
use Core\ORM\Migration\Constrains\Text;

#[Table("teams")]

class Team
{
    public function __construct(
        #[Id]
        #[AutoIncrement]
        #[Column(unique: true)]
        public int $team_id,

        #[Text]
        #[Column(unique: true)]
        public string $name,

        #[Text]
        #[Column(unique: true)]
        public string $game,

        #[Column()]
        public int $club_id,
    ) {}
}
