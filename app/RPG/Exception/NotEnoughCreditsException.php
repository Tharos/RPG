<?php

namespace RPG\Exception;

use RuntimeException;



class NotEnoughCreditsException extends RuntimeException implements IException
{

	/**
	 * @var int
	 */
	private $current;

	/**
	 * @var int
	 */
	private $required;



	/**
	 * @param string $message
	 * @param int $current
	 * @param int $required
	 */
	public function __construct($message, $current, $required)
	{
		parent::__construct($message);

		$this->current = $current;
		$this->required = $required;
	}

}
