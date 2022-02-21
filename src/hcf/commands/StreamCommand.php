<?php

namespace hcf\commands;

use hcf\Loader;

use pocketmine\command\{CommandSender, Command};

use pocketmine\utils\TextFormat as TE;

use libs\discord\Webhook;
use libs\discord\Message;
use libs\discord\Embed;

class StreamCommand extends Command
{

    public function __construct()
    {

        parent::__construct("stream");
        parent::setAliases(["live"]);
        $this->setPermission('stream.command');
        parent::setDescription("an exclusive command for streamers");

    }

    public function execute(CommandSender $sender, string $label, array $args): void
    {

        if (!$sender->hasPermission("stream.command.use")) {

            $sender->sendMessage(TE::RED . "You have not permissions to use this command");

            return;

        }

        if (empty($args[0])) {

            $sender->sendMessage(TE::RED . "Use: /{$label} <message>");

            return;

        }

        $channelName = implode(" ", $args);
        $this->sendWebhook($channelName, $sender->getName());

        Loader::getInstance()->getServer()->broadcastMessage("§5---------------------------------------------");
        Loader::getInstance()->getServer()->broadcastMessage("§l§d" . $sender->getName() . " §l§eEstá en directo! Su canal::" . "\n §d" . $channelName);
        Loader::getInstance()->getServer()->broadcastMessage("§5---------------------------------------------");
    }

    public function sendWebhook(string $message, string $playerSender)
    {
        $webhook = new Webhook("");
        $msg = new Message();

        $msg->setUsername("HCF-CORE");

        $embed = new Embed();

        $embed->setTitle("New stream for " . $playerSender);
        $embed->setDescription($playerSender . " está en stream! Su canal es: " . $message);

        $msg->addEmbed($embed);

        $webhook->send($msg);
    }

}
