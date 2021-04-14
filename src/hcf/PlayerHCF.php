<?php

namespace hcf;

use hcf\HCFLoad;

use pocketmine\Player;

use pocketmine\item\Item;

use pocketmine\nbt\tag\{CompoundTag,IntTag,StringTag};

use pocketmine\utils\{Config,TextFormat as Text};

class PlayerHCF extends Player {

public const PUBLIC_CHAT = 0;

public const FACTION_CHAT = 1;

public const ALLY_CHAT = 2;

public const STAFF_CHAT = 3;

public $hcf;

public $class = "";
public $oldClass;

public $region = "";

public $balance = 0;

public $invites = [];

public $logout = false;

public $reclaim = false;
  
public $chat = self::PUBLIC;

/** @here Scoreboard **/
public $scoreboard;

/** @var Array[] String **/
public $permissions = [];

/** @var Array[] Item **/
public $inventory = [];

/** @var Array[] Item **/
public $armorInventory = [];

public $faction;

public $factionRole;

public $kills = 0;
public $deaths = 0;

public $cooldown = ["EnderPearl" => 0];

public function addKill(int $amount):void{
$this->kills += $amount;
}

public function addDeath(int $amount):void{
$this->deaths += $amount;
}

public function setLogout(bool $value = true){
$this->logout = $value;  
}

public function getLogout(): bool {
return $this->logout ?? null;
}

public function getCooldown(string $name): int {
switch($name){
case "EnderPearl":
return (int)$this->cooldown["EnderPearl"];  
break;
     }
}
 
public function setStaffMode(bool $value = false): void {
$this->staff["enabled"] = $value;
}

public function getStaffMode(): bool {
return $this->staff["enabled"];
}

public function sendStaffMode(): void {
foreach($this->getInventory()->getContents() as $item){
  $this->setItems($item);
}
$this->getInventory()->clearAll(true);
$this->getArmorInventory()->clearAll(true);
$this->removeAllEffects();
$this->setGamemode(0);
$this->setAllowFlight(true);
$this->setFlying(true);
$freezeId = Item::get(Item::FROSTED_ICE, 0, 1);
$freezeId->setCustomName(Text::AQUA . "Freeze Player"); 
$freezeId->setLore([Text::GRAY . "Right click to freeze the player, Left click to see the frozen status of the player (not added)"]);
$freeezeTag = $freezeId->getNamedTag();
$freeezeTag->setString("staffmode", "freezeItem");
$freezeId->setNamedTag($freeezeTag);

$randomTeleport = Item::get(Item::COMPASS, 0, 1);
$randomTeleport->setCustomName(Text::YELLOW . "Random Teleport");
$randomTeleport->setLore([Text::GRAY . "Left Click to teleport to a player or a block"]);
$randomTeleportTag = $randomTeleport->getNamedTag();
$randomTeleportTag->setString("staffmode", "randomTeleport");
$randomTeleport->setNamedTag($randomTeleportTag);

$vanish = Item::get(351, 10, 1);
$vanish->setCustomName(Text::GREEN . "Vanish"); 
$vanish->setLore([Text::GRAY . "Click Left to hide or show"]);
$vanishTag = $vanish->getNamedTag();
$vanishTag->setString("staffmode", "vanishItem");
$vanish->setNamedTag($vanishTag);

$seeInventory = Item::get(Item::BOOK, 0, 1);

$this->addTitle(Text::AQUA . "STAFFMODE", Text::GREEN . "Enabled");
$this->setStaffMode(true);
}

public function notSendStaffMode(): void {
$this->getInventory()->clearAll(true);
$this->getArmorInventory()->clearAll(true);

$this->inventory = [];
$this->setGamemode(0);
$this->setAllowFlight(false);
$this->setFlying(false);
foreach(HCFLoad::getInstance()->getServer()->getOnlinePlayers() as $player){
$player->showPlayer($this);
}
$this->setStaffMode(false);
}
}