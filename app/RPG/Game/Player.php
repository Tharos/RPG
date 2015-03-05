<?php

namespace RPG\Game;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Nette\Object;
use RPG\Exception\InvalidArgumentException;
use RPG\Exception\NotEnoughCreditsException;



/**
 * @ORM\Entity
 */
class Player extends Object
{

	const CREDITS_DEFAULT = 100;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string", length=20)
	 * @var string
	 */
	private $id;

	/**
	 * @ORM\OneToMany(targetEntity="Item", mappedBy="owner")
	 * @var Item[]
	 */
	private $items;

	/**
	 * @ORM\Column(type="integer", options={"default": 100})
	 * @var int
	 */
	private $credits = self::CREDITS_DEFAULT;



	/**
	 * @param string $id
	 */
	public function __construct($id)
	{
		$this->id = $id;
		$this->items = new ArrayCollection;
	}



	/**
	 * @param Item $item
	 * @throws NotEnoughCreditsException
	 */
	public function buyItem(Item $item)
	{
		$price = $item->getPrice();

		if ($price > $this->credits) {
			throw new NotEnoughCreditsException($this->credits, $price);
		}

		$this->credits -= $price;
		$item->getOwner()->receiveCredits($price);
		$item->changeOwner($this);
	}



	/**
	 * @param int $credits
	 * @throws InvalidArgumentException
	 */
	public function receiveCredits($credits)
	{
		if ($credits <= 0) {
			throw new InvalidArgumentException('Invalid credits value given: ' . $credits . '.');
		}

		$this->credits += $credits;
	}



	/**
	 * @return int
	 */
	public function getCredits()
	{
		return $this->credits;
	}



	/**
	 * Use only for management of inverse side of bidirectional association
	 *
	 * @param Item $item
	 * @throws InvalidArgumentException
	 */
	public function removeItem(Item $item)
	{
		if (!$item->isReleased()) {
			throw new InvalidArgumentException("Cannot remove item that isn't released.");
		}

		if (!$this->items->contains($item)) {
			throw new InvalidArgumentException("Player $this doesn't have given item $item.");
		}

		$this->items->removeElement($item);
	}



	/**
	 * Use only for management of inverse side of bidirectional association
	 *
	 * @param Item $item
	 * @throws InvalidArgumentException
	 */
	public function addItem(Item $item)
	{
		if (!$item->isReleased()) {
			throw new InvalidArgumentException("Cannot add item that isn't released.");
		}

		if ($this->items->contains($item)) {
			throw new InvalidArgumentException("Player $this already has given item $item.");
		}

		$this->items->add($item);
	}



	/**
	 * @return string
	 */
	public function __toString()
	{
		return '#' . $this->id;
	}

}
