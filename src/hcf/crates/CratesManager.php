<?php

namespace hcf\crates;

use hcf\crates\types\Crate;
use hcf\Loader;

class CratesManager
{

    public static array $crates = [];

    public static function createCrate(string $crateName, array $items)
    {
        self::$crates[$crateName] = new Crate($crateName, $items);
    }

    public static function getCrate(string $crateName): Crate
    {
        return self::$crates[$crateName];
    }

    public static function getAllCrates(): array
    {
        $crates = [];
        $cratesData = glob(Loader::getInstance()->getDataFolder() . "crates" . DIRECTORY_SEPARATOR . "*.yml");
        foreach ($cratesData as $crateFile) {
            $crateName = explode(".", $crateFile);
            $crates[] = $crateName[0];
        }
        return $crates;
    }

}