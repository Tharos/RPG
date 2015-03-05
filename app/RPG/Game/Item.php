<?php

namespace RPG\Game;

use Closure;
use Doctrine\ORM\Mapping as ORM;
use Nette\Object;



/**
 * @ORM\Entity
 * @ORM\EntityListeners({"ItemEventsInitializer"})
 *
 * @method onOwnerChanged(Item $item, Player $oldOwner, Player $newOwner)
 */
class Item extends Object
{

	const PLACE_INVENTORY = 'inventory';
	const PLACE_MARKET = 'market';

	/**
	 * @var Closure[]
	 */
    public $onOwnerChanged = [];

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Player", inversedBy="items")
	 * @ORM\JoinColumn(nullable=FALSE)
	 * @var Player
	 */
	private $owner;

	/**
	 * ORM\Column(type="boolean", options={"default": 1})
	 * @var bool
	 */
	private $isReleased = TRUE;

	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	private $price;

	/**
	 * @ORM\Column(type="string", options={"default": "inventory"})
	 * @var string
	 */
	private $place = self::PLACE_INVENTORY;



	/**
	 * @param int $id
	 * @param Player $owner
	 * @param int $price
	 */
	public function __construct($id, Player $owner, $price)
	{
		$this->id = $id;
		$this->owner = $owner;;
		$this->price = $price;

		$owner->addItem($this);
		$this->isReleased = FALSE;
	}



	/**
	 * @param Player $newOwner
	 */
	public function changeOwner(Player $newOwner)
	{
		if ($this->owner !== $newOwner) {
			$this->isReleased = TRUE;

			$oldOwner = $this->owner;
			$oldOwner->removeItem($this);
			$this->owner = $newOwner;
			$newOwner->addItem($this);

			$this->isReleased = FALSE;
			$this->moveToInventory();

			$this->onOwnerChanged($this, $oldOwner, $newOwner);
		}
	}



	/**
	 * @return bool
	 */
	public function isReleased()
	{
		return $this->isReleased;
	}



	/**
	 * @return int
	 */
	public function getPrice()
	{
		return $this->price;
	}



	/**
	 * @return Player
	 */
	public function getOwner()
	{
		return $this->owner;
	}



	public function moveToInventory()
	{
		$this->place = self::PLACE_INVENTORY;
	}



	public function moveToMarket()
	{
		$this->place = self::PLACE_MARKET;
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return '#' . $this->id;
	}

}
