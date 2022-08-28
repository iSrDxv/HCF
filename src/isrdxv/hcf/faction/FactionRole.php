<?php

namespace isrdxv\hcf\faction;

use pocketmine\utils\EnumTrait;

/**
 * @method static LEADER()
 * @mdthod static CO_LEADER()
 * @method static MEMBER()
 */
final class FactionRole
{
  use EnumTrait;
  
  abstract protected static function setup(): void
  {
    self::registerAll(new self("LEADER"), new self("CO_LEADER"), new self("MEMBER"));
  }

}