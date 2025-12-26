<?php


use Core\ORM\Migration\Attributes\Table;
// use Core\Lombok\Getter;
use Core\ORM\Migration\Attributes\Column;
use Core\ORM\Migration\Constrains\AutoIncrement;
use Core\ORM\Migration\Constrains\Defaulte;
use Core\ORM\Migration\Constrains\Id;
use Core\ORM\Migration\Constrains\Text;
use Core\ORM\Migration\Constrains\TimeStamp;

#[Attribute(Attribute::TARGET_CLASS)]
#[Table("clubs")]
class Club
{

    public function __construct(
        #[Id]
        #[AutoIncrement]
        #[Column(unique: true)]
        public int $club_id,

        #[Column(nullable: false, unique: true)]
        #[Text]
        public string $name,

        #[Column(nullable: false, unique: false)]
        public string $city,

        #[TimeStamp]
        #[Defaulte("CURRENT_TIMESTAMP")]
        #[Column(nullable: false, unique: true)]
        public string $created_at,
    ) {}
}
