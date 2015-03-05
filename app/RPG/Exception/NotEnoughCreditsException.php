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
	 * @param int $current
	 * @param int $required
	 */
	public function __construct($current, $required)
	{
		parent::__construct();

		$this->current = $current;
		$this->required = $required;
	}

}
