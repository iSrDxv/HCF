<?php

namespace hcf\crates\command;

use hcf\crates\CratesManager;
use hcf\PlayerHCF;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class CrateCommand extends Command
{

    public function __construct(string $name, Translatable|string $description = "", Translatable|string|null $usageMessage = null, array $aliases = [])
    {
        parent::__construct($name, $description, $usageMessage, $aliases);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof PlayerHCF) {
            if (isset($args[0])) {
                if ($args[0] === "help") {
                    $sender->sendMessage(TextFormat::colorize("&7---------------------------"));
                    $sender->sendMessage(TextFormat::colorize("&a- &7/cr create (crateName)"));
                    $sender->sendMessage(TextFormat::colorize("&a- &7/cr list"));
                    $sender->sendMessage(TextFormat::colorize("&7---------------------------"));
                }
                if ($args[0] === "create") {
                    if (!isset($args[1])) {
                        $sender->sendMessage(TextFormat::colorize("&a- &7/cr create (crateName)"));
                    }
                    CratesManager::createCrate($args[1], $sender->getInventory()->getContents());
                }
                if ($args[0] === "list") {
                    $sender->sendMessage(TextFormat::colorize("&l&6List Crates"));
                    $sender->sendMessage(TextFormat::colorize("&7---------------------------"));
                    foreach (CratesManager::getAllCrates() as $allCrate) {
                        $sender->sendMessage(TextFormat::colorize("&6- &7".$allCrate));
                    }
                    $sender->sendMessage(TextFormat::colorize("&7---------------------------"));
                }
            } else {
                $sender->sendMessage(TextFormat::colorize("&cUsa: /cr help &7Para Obtener La Lista De Comandos"));
            }
        }
    }

}