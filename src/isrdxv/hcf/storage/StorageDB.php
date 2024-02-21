<?php

namespace isrdxv\hcf\storage;

use isrdxv\hcf\HCFLoader;
use isrdxv\hcf\storage\data\PlayerData;
use pocketmine\promise\Promise;
use pocketmine\promise\PromiseResolver;
use pocketmine\promise\PromiseSharedData;
use poggit\libasynql\DataConnector;
use poggit\libasynql\libasynql;
use poggit\libasynql\SqlError;

class StorageDB implements Storage
{
    private string $name;

    private HCFLoader $loader;

    private DataConnector $database;

    function __construct()
    {
        $this->loader = HCFLoader::getInstance();
    }

    function load(): void
    {
        $value = $this->loader->getConfigData()->getDatabaseValues();
        $this->database = libasynql::create($this->loader, $value, [
            "mysql" => "",
            "sqlite" => ""
        ]);
        $this->name = strtolower($value["type"] ?? "isrdxv");

        $this->database->executeGeneric("player.table");
        $this->database->executeGeneric("faction.table");
    }

    function unload(): void
    {
        if (isset($this->database)) {
            $this->database?->close();
        }
    }

    function isInDatabase(string $xuid): Promise
    {
        $promiseResolver = new PromiseResolver();
        $this->getPlayerData($xuid)->onCompletion(function(?PlayerData $playerData) use($promiseResolver): void {
            $promiseResolver->resolve($playerData !== null);
        }, fn() => $promiseResolver->reject());
        return $promiseResolver->getPromise();
    }

    function getPlayerData(string $xuid): Promise
    {
        $promiseResolver = new PromiseResolver();
        $this->database->executeSelect("player.gets.data", ["xuid" => $xuid], function(array $row) use($promiseResolver): void {
            if (isset($row)) {
                $promiseResolver->resolve(PlayerData::deserealize($row));
            } else {
                $promiseResolver->resolve(null);
            }
        }, function(SqlError $error) use($promiseResolver): void {
            $this->loader->getLogger()->warning("[" . $error->getQuery() . "] " . $error->getErrorMessage());
            $promiseResolver->reject();
        });
        return $promiseResolver->getPromise();
    }
}