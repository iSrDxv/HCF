<?php

namespace hcf\crates\types;

use hcf\crates\utils\CratesUtils;
use hcf\Loader;
use pocketmine\item\Item;
use pocketmine\utils\Config;

class Crate
{

    public ?string $crateName = "null";
    public array $items = [];
    public Config $config;

    public function __construct(string $crateName, array $items)
    {
        $this->setItems($items);
        $this->setCrateName($crateName);
        $this->setConfig(new Config(Loader::getInstance()->getDataFolder()."crates".DIRECTORY_SEPARATOR.$crateName.".yml", Config::YAML));
        $configItems = [];
        foreach($this->getItems() as $slot => $item){
            $configItems[$slot] = CratesUtils::itemSerialize($item);
        }
        $this->getConfig()->set("name", $this->getCrateName());
        $this->getConfig()->set("items", $configItems);
        $this->getConfig()->save();
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function setConfig(Config $config): void
    {
        $this->config = $config;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function setCrateName(?string $crateName): void
    {
        $this->crateName = $crateName;
    }

    public function getCrateName(): ?string
    {
        return $this->crateName;
    }

    public function getRandomReward(): Item
    {
        return $this->items[array_rand($this->items)];
    }

}