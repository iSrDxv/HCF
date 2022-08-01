<?php

namespace isrdxv\hcf\command;

abstract class Command extends \pocketmine\command\Command
{
  /** @var SubCommand[] **/
  private array $subCommands = [];
  
  public function __construct(string $name, string $description, string $usage, array $aliases = [])
  {
    parent::__construct($name, $description, $usage, $aliases);
  }
  
  abstract public function execute(\pocketmine\command\CommandSender $sender, string $label, array $args): void {}
  
  public function addSubCommand(SubCommand $subCommand): void
  {
    $this->subCommands[$subCommand->getName()] = $subCommand;
    if ($subCommand->getAliases() !== []) {
      foreach($subCommand->getAliases() as $alias) {
        $this->subCommands[$alias] = $subCommand;
      }
    }
  }
  
  public function getSubCommand(string $cmd): ?Subcommand
  {
    return isset($this->subCommands[$cmd]) ? $this->subCommands[$cmd] : null;
  }
  
}