
<?php

use Core\Database\Migration\Column;
use Core\Database\Migration\Table;

#[Table("clubs")]
class Club
{


    public function __construct(
        #[Column("INT", primary: true, autoInc: true, unique: true)]
        public int $club_id,

        #[Column("VARCHAR(255)", primary: false, nullable: false, unique: true)]
        public string $name,

        #[Column("VARCHAR(255)", primary: false, nullable: false, unique: false)]
        public string $city,

        #[Column("TIMESTAMP", primary: false, nullable: false, unique: true,default: "CURRENT_TIMESTAMP")]
        public string $created_at,
    ) {}
}
