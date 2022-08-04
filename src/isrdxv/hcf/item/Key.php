<?php

namespace isrdxv\hcf\item;

use pocketmine\item\Item;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;

class Key extends Item
{
  
  private ?string $crateName = null;
  
  public function __construct($itemIdentifier, $name)
  {
    parent::__construct($itemIdentifier, $name);
    $this->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 3));
  }
  
  public function getCrateName(): string
  {
    return $this->crateName;
  }
  
  public function setCrateName(string $name): void
  {
    $this->crateName = $name;
  }
  
}