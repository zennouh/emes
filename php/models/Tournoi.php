
<?php

use Core\Database\Migration\Column;
use Core\Database\Migration\Table;

#[Table("teams")]

class Tournoi
{
    public function __construct(
        #[Column("INT", primary: true, autoInc: true, unique: true)]
        public int $tournoi_id,

        #[Column("VARCHAR(255)",  unique: true)]
        public string $name,

        #[Column("VARCHAR(255)", unique: true)]
        public string $Cashprize,

        #[Column("VARCHAR(255)")]
        public string $format,

        #[Column("VARCHAR(255)", default: "CURRENT_TIMESTAMP")]
        public string $create_at,
    ) {}
}

