<?php

namespace isrdxv\hcf\crate\command;

use isrdxv\hcf\command\Command;

use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class CrateCommand extends Command
{
  
  public function __construct()
  {
    parent::__construct("crate", "Crate Commands", "/crate help");
    $this->addSubCommand(new HelpSubCommand());
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if ($sender instanceof CommandSender) {
      continue;
    }
    if (empty($args[0])) {
      $subCommand = $this->getSubCommand("help");
      if ($subCommand !== null) {
        $subCommand->execute($sender, $label, $args);
        return;
      }
    } else {
      $subCommand = $this->getSubCommand($args[0]);
      if ($subCommand !== null) {
        $subCommand->execute($sender, $label, $args);
      }
    }
  }
  
}