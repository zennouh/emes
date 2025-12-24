<?php


namespace Core\ORM\Migration\Constrains;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]

class Defaulte
{
    public function __construct(public ?string $value = null) {}
}
