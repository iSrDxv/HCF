<?php

namespace isrdxv\hcf\storage;

use isrdxv\hcf\HCFLoader;
use pocketmine\promise\Promise;

interface Storage
{
    function __construct();

    function load(): void;

    function unload(): void;

    function isInDatabase(string $name): Promise;

    function setFaction(): Promise;

    function setPlayerData(): Promise;

    function getPlayerData(string $xuid): Promise;

    function getFactionData(): Promise;
}