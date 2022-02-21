<?php

namespace hcf\crates;

use hcf\crates\types\Crate;

class CratesManager
{

    public static array $crates = [];

    public static function createCrate(string $crateName, array $items)
    {
        self::$crates[$crateName] = new Crate($crateName, $items);
    }

}