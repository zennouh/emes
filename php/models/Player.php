<?php

use Core\Database\Migration\Column;
use Core\Database\Migration\ForeignKey;
use Core\Database\Migration\Table;

#[Table("players")]
class Player
{
    public function __construct(
        #[Column("INT", primary: true, autoInc: true, unique: true)]
        public int $player_id,

        #[Column("VARCHAR(255)",)]
        public string $pseudo,

        #[Column("VARCHAR(255)", default: "noah")]
        public string $role,

        #[Column("FLOAT", default: 0)]
        public float $salary,

        #[Column("INT", unique: false)]
        #[ForeignKey("teams", "team_id")]
        protected int $team_id,
    ) {}
}


// Pseudo, Rôle, Salaire, #EquipeID