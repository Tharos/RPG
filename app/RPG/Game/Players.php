<?php

namespace RPG\Game;

use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette\Object;



class Players extends Object
{

	const MESSAGES_LIMIT = 10;

	/**
	 * @var EntityRepository
	 */
	private $playerRepository;

	/**
	 * @var EntityRepository
	 */
	private $messageRepository;



	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->playerRepository = $entityManager->getRepository(Player::class);
		$this->messageRepository = $entityManager->getRepository(Message::class);
	}



	/**
	 * @return Player[]
	 */
	public function getPlayersOverview()
	{
		$players = $this->playerRepository->findBy([], ['id' => 'ASC']);

		$ids = array_map(function (Player $player) {
			return $player->id;
		}, $players);

		$this->playerRepository->createQueryBuilder('p')
			->select('partial p.{id}')
			->leftJoin('p.items', 'i')->addSelect('i')
			->where('p.id IN (:players)')->setParameter('players', $ids)
			->orderBy('i.id')
			->getQuery()->getResult();

		return $players;
	}



	/**
	 * @return Message[]
	 */
	public function getMessages()
	{
		return $this->messageRepository->findBy([], ['created' => 'DESC', 'id' => 'DESC'], self::MESSAGES_LIMIT);
	}

}
