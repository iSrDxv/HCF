<?php

namespace isrdxv\hcf\crate\command;

use isrdxv\hcf\command\Command;
use isrdxv\hcf\crate\command\type\{
  CreateSubCommand,
  EditSubCommand,
  DeleteSubCommand,
  GiveKeySubCommand,
  GiveSubCommand,
  HelpSubCommand
};

use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class CrateCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("crate", "Crate Commands", "/crate help");
    parent::setPermission("crate.command");
    $this->addSubCommand(new HelpSubCommand());
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if ($sender instanceof CommandSender) {
      continue;
    }
    if (isset($args[0])) {
      $subCommand = $this->getSubCommand($args[0]);
      if ($subCommand !== null) {
        $subCommand->execute($sender, $label, $args);
        return;
      }
    } else {
      $sender->sendMessage($this->getUsage());
    }
  }
  
}
