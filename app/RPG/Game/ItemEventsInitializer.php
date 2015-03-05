<?php

namespace RPG\Game;

use Nette\Object;
use Doctrine\ORM\Mapping as ORM;



class ItemEventsInitializer extends Object
{

	/**
	 * @var Notifier
	 */
	private $notifier;



	/**
	 * @param Notifier $notifier
	 */
	public function __construct(Notifier $notifier)
	{
		$this->notifier = $notifier;
	}



	/**
	 * @ORM\PostLoad
	 * @param Item $item
	 */
	public function initializeEvents(Item $item)
	{
		$item->onOwnerChanged['notify'] = function (Item $item, Player $oldOwner, Player $newOwner) {
			$this->notifier->notifyPlayerAboutRemovedItem($oldOwner, $item);
			$this->notifier->notifyPlayerAboutAddedItem($newOwner, $item);
		};
	}

}
