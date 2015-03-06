<?php

namespace RPG\Game;

use Nette\Object;



class PurchaseDetails extends Object
{

	/**
	 * @var Item
	 */
	private $item;

	/**
	 * @var Player
	 */
	private $oldOwner;

	/**
	 * @var Player
	 */
	private $newOwner;



	/**
	 * @param Item $item
	 * @param Player $oldOwner
	 * @param Player $newOwner
	 */
	public function __construct(Item $item, Player $oldOwner, Player $newOwner)
	{
		$this->item = $item;
		$this->oldOwner = $oldOwner;
		$this->newOwner = $newOwner;
	}



	/**
	 * @return Item
	 */
	public function getItem()
	{
		return $this->item;
	}



	/**
	 * @return Player
	 */
	public function getOldOwner()
	{
		return $this->oldOwner;
	}



	/**
	 * @return Player
	 */
	public function getNewOwner()
	{
		return $this->newOwner;
	}

}
