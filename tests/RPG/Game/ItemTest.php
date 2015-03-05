<?php

namespace Test;

require __DIR__ . '/../../bootstrap.php';

use Mockery;
use RPG\Game\Item;
use RPG\Game\Player;
use Tester\Assert;
use Tester\TestCase;



class ItemTest extends TestCase
{

	public function testChangeOwner()
	{
		$playerA = Mockery::mock(Player::class)
			->shouldReceive('addItem')->getMock()
			->shouldReceive('removeItem')->getMock();

		$playerB = Mockery::mock(Player::class)
			->shouldReceive('addItem')->getMock();

		$item = new Item(1, $playerA, 100);

		Assert::same($playerA, $item->getOwner());

		$item->changeOwner($playerB);

		Assert::same($playerB, $item->getOwner());
	}

}



(new ItemTest)->run();


