<?php
declare(strict_types = 1);

namespace isrdxv\hcf\config;

use pocketmine\utils\TextFormat;

final class ConfigData
{
    //SERVER DATA
    private string $name;

    private string $description;

    private array $motd;

    private int $maxPlayers;

    private string $address;

    private bool $maintenance;

    private array $bypass;

    private int $border;

    //FACTION DATA
    private int $maxAllies;

    private int $maxLimit;

    private bool $allyFriendlyFire;

    private array $warzoneBreakAfter;

    //WEBHOOKS
    private string $global;

    private string $sotw;

    private string $eotw;

    private string $koth;

    //DATABASE 
    private array $database;

    function __construct(array $data)
    {
        //SERVER
        $this->name = $data["SERVER"]["NAME"];
        $this->description = $data["SERVER"]["DESCRIPTION"];
        $this->motd = $data["SERVER"]["MOTD"];
        $this->maxPlayers = $data["SERVER"]["MAX-PLAYERS"];
        $this->address = $data["SERVER"]["ADDRESS"];
        $this->maintenance = $data["SERVER"]["ADDRESS"];
        $this->bypass = $data["SERVER"]["BYPASS"];
        $this->border = $data["SERVER"]["MAP-BORDER"];

        //FACTION
        $this->maxAllies = $data["FACTION-PLAYER"]["MAX-ALLIES"];
        $this->maxLimit = $data["FACTION-PLAYER"]["MAX-LIMIT"];
        $this->allyFriendlyFire = $data["FACTION-PLAYER"]["ALLY-FRIENDLY-FIRE"];
        $this->warzoneBreakAfter = $data["FACTION-PLAYER"]["WARZONE-BREAK-AFTER"];

        //WEBHOOKS
        $webhooks = $data["WEBHOOKS"];
        $this->global = $webhooks["global"];
        $this->koth = $webhooks["koth"];
        $this->sotw = $webhooks["sotw"];
        $this->eotw = $webhooks["eotw"];

        //DATABASE
        $this->database = $data["DATABASE"];
        var_dump($this->database);
    }

    //SERVER
    function getName(): string
    {
        return $this->name;
    }

    function getDescription(): string
    {
        return $this->description;
    }

    function getMOTD(): array
    {
        return $this->motd;
    }

    function getMaxPlayers(): int
    {
        return $this->maxPlayers;
    }

    function getAddress(): string
    {
        return $this->address;
    }

    function getMaintenance(): bool
    {
        return $this->maintenance;
    }

    function getBypass(): array
    {
        return $this->bypass;
    }

    function getMapBorder(): int
    {
        return $this->border;
    }

    //FACTION
    function getFactionMaxAllies(): int
    {
        return $this->maxAllies;
    }

    function getFactionMaxLimit(): int
    {
        return $this->maxLimit;
    }

    function getFactionAllyFriendlyFire(): bool
    {
        return $this->allyFriendlyFire;
    }

    function getFactionWarzoneBreakAfter(string $key): int
    {
        return $this->warzoneBreakAfter[$key] ?? 300;
    }

    //WEBHOOKS
    function getWebhookGlobal(): string
    {
        return $this->global;
    }

    function getWebhookKoth(): string
    {
        return $this->koth;
    }

    function getWebhookSOTW(): string
    {
        return $this->sotw;
    }

    function getWebhooEOTW(): string
    {
        return $this->eotw;
    }

    //DATABASE
    function getDatabaseValues(): array
    {
        return $this->database;
    }
}