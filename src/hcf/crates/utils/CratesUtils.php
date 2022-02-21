<?php

namespace hcf\crates\utils;

use hcf\PlayerHCF;
use libs\invmenu\InvMenu;
use libs\invmenu\transaction\InvMenuTransaction;
use libs\invmenu\type\InvMenuTypeIds;
use pocketmine\item\Item;
use pocketmine\utils\TextFormat;

class CratesUtils
{

    public static function openLootCrateEdit(string $crate, PlayerHCF $playerHCF)
    {
        $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
        $menu->setName(TextFormat::colorize("&cLoot Crate Edit"));
        $menu->setListener(function (InvMenuTransaction $transaction){
            $transaction->continue();
        });
        $menu->setInventoryCloseListener(function() use ($crate, $menu, $playerHCF){
            $contents = $menu->getInventory()->getContents();
            $playerHCF->getInventory()->setContents($contents);
        });
    }

    public static function itemSerialize(Item $item): array
    {
        return $item->jsonSerialize();
    }

    public static function itemDeserialize(array $items): Item
    {
        return Item::jsonDeserialize($items);
    }

}