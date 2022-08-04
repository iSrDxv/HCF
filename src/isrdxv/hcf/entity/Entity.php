<?php

namespace isrdxv\hcf\entity;

use isrdxv\hcf\HCFLoader;

use pocketmine\network\mcpe\convert\SkinAdapterSingleton;
use pocketmine\network\mcpe\protocol\{
  PlayerListPacket,
  AddPlayerPacket,
  RemoveActorPacket,
  PlayerListEntry,
  AdventureSettingsPacket,
  types\entity\EntityMetadataFlags,
  types\entity\FloatMetadataProperty,
  types\entity\LongMetadataProperty,
  types\inventory\ItemStack,
  types\DeviceOS,
  types\inventory\ItemStackWrapper,
  types\entity\EntityMetadataProperties
};
use pocketmine\entity\{
  Entity,
  Skin
};
use pocketmine\world\Position;
use pocketmine\player\Player;
use pocketmine\Server;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Entity
{
  /** @var UuidInterface **/
  private $uuid;
  
  /** @var Int **/
  private $entityId;
  
  /** @var Skin **/
  private $skin;
  
  /** @var Position **/
  private $position;
  
  /** @var Float **/
  private $yaw = 0.0;
  
  /** @var Float **/
  private $pitch = 0.0;
  
  /** @var Float **/
  private $scale = 1.5;
  
  /** @var TagEditor **/
  private $tagEditor;
  
  public function __construct()
  {
    $this->uuid = Uuid::uuid4();
    $this->entityId = Entity::nextRuntimeId();
    $this->tagEditor = new TagEditor($this);
  }
  
  public function setSkin(Skin $skin): void
  {
    $this->skin = $skin;
  }
  
  public function getSkin(): Skin
  {
    return $this->skin;
  }
  
  public function getYaw(): float
  {
    return $this->yaw;
  }
  
  public function setYaw(float $yaw): void
  {
    $this->yaw = $yaw;
  }
  
  public function setPitch(float $pitch): void
  {
    $this->pitch = $pitch;
  }
  
  public function getPitch(): float
  {
    return $this->pitch;
  }
  
  public function setPosition(Position $position): void
  {
    $this->position = $position;
  }
  
  public function getPosition(): Position
  {
    return $this->position;
  }
  
  public function spawnTo(Player $player): void
  {
    $packets[] = PlayerListPacket::add([PlayerListEntry::createAdditionEntry($this->uuid, $this->entityId, "", SkinAdapterSingleton::get()->toSkinData($this->skin))]);
    $flags = 
      1 << EntityMetadataFlags::CAN_SHOW_NAMETAG |
      1 << EntityMetadataFlags::ALWAYS_SHOW_NAMETAG |
      1 << EntityMetadataFlags::IMMOBILE;
    $actorMetadata = [
      EntityMetadataProperties::FLAGS => new LongMetadataProperty($flags),
      EntityMetadataProperties::SCALE => new FloatMetadataProperty($this->scale)
    ];
    $packets[] = AddPlayerPacket::create(
      $this->uuid,
      "",
      $this->entityId,
      "",
      $this->position,
      null,
      $this->getPitch(),
      $this->getYaw(),
      $this->getYaw(),
      ItemStackWrapper::legacy(ItemStack::null()),
      $actorMetadata,
      AdventureSettingsPacket::create(0, 0, 0, 0, 0, $this->entityId),
      [],
      "",
      DeviceOS::UNKNOWN
    );
    $packets[] = PlayerListPacket::remove([PlayerListEntry::createRemovalEntry($this->uuid)]);
    foreach($this->tagEditor->getLines() as $line) {
      $line->spawnTo($player);
    }
    foreach($packets as $packet) {
      $player->getNetworkSession()->sendDataPacket($packet);
    }
  }
  
  public function despawnFrom(Player $player): void
  {
    $packet = new RemoveActorPacket();
    $packet->actorUniqueId = $this->entityId;
    $player->getNetworkSession()->sendDataPacket($packet);
    foreach($this->tagEditor->getLines() as $line) {
      $line->despawnFrom($player);
    }
  }
  
  public function executeEmote(string $emoteId, bool $noStop = false, int $second): void
  {
    if ($noStop === false) {
      HCFLoader::getInstance()->scheduleRepeatingTask(new EmoteRepeatingTimer($emoteId, $this, $second), 20);
    } else {
      HCFLoader::getInstance()->scheduleRepeatingTask(new EmoteRepeating($emoteId, $this, $second), 20);
    }
  }
  
  public function fromEntity(): Entity
  {
    return $this->position !== null ? $this->position->getWorld()->getEntity($this->entityId) : Server::getInstance()->getWorldManager()->getDefaultWorld()->getEntity($this->entityId);
  }
  
  public function toArray(): array
  {
    $tags = [];
    foreach($this->tagEditor->getLines() as $line) {
      $tags[] = $line->getNameTag();
    }
    return [
      "nametag" => $tags,
      "x" => $this->position->getX(),
      "y" => $this->position->getY(),
      "z" => $this->position->getZ(),
      "world" => $this->position !== null ? $this->position->getWorld()->getFolderName() : Server::getInstance()->getDefaultWorld()->getFolderName()
    ];
  }
  
}
