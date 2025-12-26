
<?php

use Core\ORM\Migration\Attributes\Column;
use Core\ORM\Migration\Attributes\ForeignKey;
use Core\ORM\Migration\Attributes\Table;
use Core\ORM\Migration\Constrains\AutoIncrement;
use Core\ORM\Migration\Constrains\Id;
use Core\ORM\Migration\Constrains\Text;

#[Table("sponsors")]

class Sponsor
{
    public function __construct(
        #[Id]
        #[AutoIncrement]
        #[Column(unique: true)]
        public int $sponsor_id,

        #[Text]
        #[Column(unique: true)]
        public string $name,

        #[Text()]
        #[Column()]
        public string $finace,

        #[Column()]
        #[ForeignKey("tournois", "tournoi_id")]
        public int $tournoi_id,


    ) {}
}
