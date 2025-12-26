
<?php


use Core\ORM\Migration\Attributes\Table;
use Core\ORM\Migration\Attributes\Column;
use Core\ORM\Migration\Constrains\AutoIncrement;
use Core\ORM\Migration\Constrains\Defaulte;
use Core\ORM\Migration\Constrains\Id;
use Core\ORM\Migration\Constrains\Text;

#[Table("toutnois")]

class Tournoi
{
    public function __construct(
        #[Id]
        #[AutoIncrement]
        #[Column(unique: true)]
        public int $tournoi_id,

        #[Text]
        #[Column(unique: true)]
        public string $name,

        #[Text]
        #[Column(unique: true)]
        public string $Cashprize,

        #[Text]
        #[Column()]
        public string $format,

        #[Text]
        #[Defaulte("CURRENT_TIMESTAMP")]
        #[Column()]
        public string $create_at,
    ) {}
}
