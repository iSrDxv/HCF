<?php

namespace isrdxv\entity\utils;

use isrdxv\hcf\entity\{
  Entity,
  utils\Tag
};

use pocketmine\world\Position;

class TagEditor 
{

  private $entity;
  
  /**
   * @var Tag[] $lines
   */
	private array $lines = [];
	
	const ONE_BREAK_LINE = 0.32;

  public function __construct($entity)
  {
    $this->entity = $entity;
  }
	
	public function getLine(int $index): Tag 
	{
		return $this->lines[$index];
	}
	
	public function putLine(string $nameTag = "", int $separator = 1): TagEditor
	{
		if (count($this->lines) == 0) {
			$position = $this->entity->getPosition()->add(0, ($this->entity->getScale() * 1.8), 0);
		} else {
		  $position = $this->lines[count($this->lines) - 1]->getPosition()->add(0, (self::ONE_BREAK_LINE * $separator), 0);
		}
		$tag = new Tag($this->entity);
	  $tag->setNameTag($nameTag);
    $tag->setPosition(new Position($position->x, $position->y, $position->z, $this->entity->getPosition()->getWorld()));
    $this->lines[] = $tag;
    return $this;
	}
    
   
  /**
   * @return Tag[]
   */
  public function getLines(): array
  {
    return $this->lines;
  }

  /**
   * @return Entity
   */
  public function getEntity()
  {
    return $this->entity;
  }

  /**
   * @param Entity $entity
   */
  public function setEntity($entity): void
  {
    $this->entity = $entity;
  }
    
}
