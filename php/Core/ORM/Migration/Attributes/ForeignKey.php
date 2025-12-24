<?php

namespace Core\Database\Migration;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]

class ForeignKey
{
    public function __construct(
        public string $reference,
        public string $colmun,
        public string $delete = "CASCADE",
        public string $update = "CASCADE",
    ) {}
}
