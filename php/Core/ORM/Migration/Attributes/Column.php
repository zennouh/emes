<?php

namespace Core\ORM\Migration\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{
    public function __construct(
        public bool $nullable = false,
        public bool $unique = false,
    ) {}
}
