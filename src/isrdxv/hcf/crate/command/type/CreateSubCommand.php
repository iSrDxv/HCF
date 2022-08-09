<?php

namespace isrdxv\hcf\crate\command\type;

use isrdxv\hcf\command\SubCommand;
use isrdxv\hcf\manager\SessionManager;
use isrdxv\hcf\form\CrateCreateForm;

use pocketminr\command\CommandSender;

class CreateSubCommand extends SubCommand
{
  
  public function __construct()
  {
    parent::__construct("create", "Create the Crate", "/crate create");
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if ($sender instanceof CommandSender) {
      //code
    } else {
      $session = SessionManager::getInstance()->get($sender->getName());
      $sender->sendForm(new CrateCreateForm($session));
    }
  }
  
}
