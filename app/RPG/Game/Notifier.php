<?php

namespace RPG\Game;

use Kdyby\Doctrine\EntityManager;
use Nette\Object;
use RPG\Exception\InvalidArgumentException;



class Notifier extends Object
{

	/**
	 * @var EntityManager
	 */
	private $entityManager;



	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}



	/**
	 * @param Player $player
	 * @param Item $item
	 * $throws InvalidArgumentException
	 */
	public function notifyPlayerAboutAddedItem(Player $player, Item $item)
	{
		if ($item->getOwner() !== $player) {
			throw new InvalidArgumentException("Player $player doesn't own item $item.");
		}

		$message = new Message($player, "You've just got item $item");
		$this->entityManager->persist($message);
	}



	/**
	 * @param Player $player
	 * @param Item $item
	 * $throws InvalidArgumentException
	 */
	public function notifyPlayerAboutRemovedItem(Player $player, Item $item)
	{
		if ($item->getOwner() === $player) {
			throw new InvalidArgumentException("Player $player still owns item $item.");
		}

		$message = new Message($player, "You've just released item $item");
		$this->entityManager->persist($message);
	}

}
