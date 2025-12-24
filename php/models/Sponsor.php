
<?php

use Core\Database\Migration\Column;
use Core\Database\Migration\ForeignKey;
use Core\Database\Migration\Table;

#[Table("sponsors")]

class Sponsor
{
    public function __construct(
        #[Column("INT", primary: true, autoInc: true, unique: true)]
        public int $sponsor_id,

        #[Column("VARCHAR(255)", unique:true)]
        public string $name,

        #[Column("VARCHAR(255)")]
        public string $finace,

        #[Column("INT")]
        #[ForeignKey("tournoi", "tournoi_id")]
        public int $tournoi_id,


    ) {}
}