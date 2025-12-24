
<?php

use Core\Database\Migration\Column;
use Core\Database\Migration\Table;

#[Table("teams")]

class Team
{
    public function __construct(
        #[Column("INT", primary: true, autoInc: true, unique: true)]
        public int $team_id,

        #[Column("VARCHAR(255)", unique: true)]
        public string $name,

        #[Column("VARCHAR(255)", unique: true)]
        public string $game,

        #[Column("INT")]
        public int $club_id,
    ) {}
}
