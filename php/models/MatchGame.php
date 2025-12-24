<?php

use Core\Database\Migration\Column;
use Core\Database\Migration\ForeignKey;
use Core\Database\Migration\Table;

#[Table("matches")]

class MatchGame
{
    public function __construct(
        #[Column("INT", true, true, false)]
        public int $match_id,

        #[Column("INT", true, false, false)]
        protected int $tournoi_id,

        #[Column("INT", false, false, false)]
        #[ForeignKey("teams", "team_id")]
        protected int $team_a,

        #[ForeignKey("teams", "team_id")]
        #[Column("INT", false, false, false)]
        protected int $team_b,

        #[Column("FLOAT", false, false, false)]
        protected int $score_a,

        #[Column("FLOAT", false, false, false)]
        protected int $score_b,

        #[Column("INT", false, false, false)]
        #[ForeignKey("teams", "team_id")]
        protected int $winner_id
    ) {}
}
