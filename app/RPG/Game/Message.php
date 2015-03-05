<?php

namespace RPG\Game;

use Doctrine\ORM\Mapping as ORM;
use Nette\Object;
use Nette\Utils\DateTime;



/**
 * @ORM\Entity
 */
class Message extends Object
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 * @var integer
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="Player")
	 * @ORM\JoinColumn(nullable=FALSE)
	 * @var Player
	 */
	private $player;

	/**
	 * @ORM\Column(type="datetime")
	 * @var DateTime
	 */
	private $created;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	private $content;



	/**
	 * @param Player $player
	 * @param string $content
	 * @param \DateTime $created
	 */
	public function __construct(Player $player, $content, \DateTime $created = NULL)
	{
		$this->player = $player;
		$this->created = DateTime::from($created);
		$this->content = $content;
	}



	/**
	 * @return DateTime
	 */
	public function getCreated()
	{
		return clone $this->created;
	}



	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

}
