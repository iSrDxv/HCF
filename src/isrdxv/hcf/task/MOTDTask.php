<?php

namespace isrdxv\hcf\task;

use pocketmine\scheduler\Task;
use pocketmine\Server;

use isrdxv\hcf\HCFLoader;

class MOTDTask extends Task
{
  private HCFLoader $loader;
  
  public function __construct(HCFLoader $loader)
  {
    $this->loader = $loader;
  }
  
  public function onRun(): void
  {
    Server::getInstance()->getNetwork()->setName($this->loader->getConfig()->get("server-name"));
  }
  
}
