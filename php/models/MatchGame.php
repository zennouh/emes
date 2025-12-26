<?php


use Core\ORM\Migration\Attributes\ForeignKey;
use Core\ORM\Migration\Attributes\Table;
use Core\ORM\Migration\Attributes\Column;
use Core\ORM\Migration\Constrains\AutoIncrement;
use Core\ORM\Migration\Constrains\Id;

#[Table("matches")]

class MatchGame
{
    public function __construct(
        #[Id]
        #[AutoIncrement]
        #[Column(unique: true)]
        public int $match_id,

        #[Column()]
        #[ForeignKey("tournois", "tournoi_id")]
        protected int $tournoi_id,

        #[Column()]
        #[ForeignKey("teams", "team_id")]
        protected int $team_a,

        #[ForeignKey("teams", "team_id")]
        #[Column()]
        protected int $team_b,

        #[Column(false, false, false)]
        protected float $score_a,

        #[Column(false, false, false)]
        protected float $score_b,

        #[Column()]
        #[ForeignKey("teams", "team_id")]
        protected int $winner_id
    ) {}
}
