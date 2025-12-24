<?php

namespace Core\Database\Migration;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Column
{
    public function __construct(
        public string $type,
        public bool $primary = false,
        public bool $autoInc = false,
        public bool $nullable = false,
        public bool $unique = false,
        public ?string $default = null
    ) {}
}
