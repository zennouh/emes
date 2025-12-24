<?php


use Core\Database\Migration\ForeignKey;
use Core\Database\Migration\Table;
use Core\ORM\Migration\Attributes\Column;
use Core\ORM\Migration\Constrains\AutoIncrement;
use Core\ORM\Migration\Constrains\Defaulte;
use Core\ORM\Migration\Constrains\Id;
use Core\ORM\Migration\Constrains\Text;

#[Table("players")]
class Player
{
    public function __construct(
        #[Id]
        #[AutoIncrement]
        #[Column(unique: true)]
        public int $player_id,

        #[Text]
        #[Column()]
        public string $pseudo,

        #[Text]
        #[Defaulte("attack")]
        #[Column()]
        public string $role,

        #[Defaulte("0")]
        #[Column()]
        public float $salary,

        #[Column()]
        #[ForeignKey("teams", "team_id")]
        protected int $team_id,
    ) {}
}


// Pseudo, Rôle, Salaire, #EquipeID