<?php

namespace RPG\Game;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Object;



class Marketplace extends Object
{

	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * @var EntityRepository
	 */
	private $playerRepository;

	/**
	 * @var EntityRepository
	 */
	private $itemRepository;



	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;

		$this->playerRepository = $entityManager->getRepository(Player::class);
		$this->itemRepository = $entityManager->getRepository(Item::class);
	}



	/**
	 * @return string[]
	 */
	public function getPlayersList()
	{
		return $this->playerRepository->findPairs('id', ['id']);
	}



	/**
	 * @return int[]
	 */
	public function getItemsList()
	{
		return $this->itemRepository->findPairs('id', ['id']);
	}



	/**
	 * @param Item|int $item
	 * @param Player|string $buyer
	 * @return PurchaseDetails
	 */
	public function buyItemByPlayer($item, $buyer)
	{
		if (!($item instanceof Item)) {
			$item = $this->itemRepository->find($item);
		}

		if (!($buyer instanceof Player)) {
			$buyer = $this->playerRepository->find($buyer);
		}

		$oldOwner = $item->getOwner();
		$buyer->buyItem($item);
		$this->entityManager->flush();

		return new PurchaseDetails($item, $oldOwner, $buyer);
	}

}
