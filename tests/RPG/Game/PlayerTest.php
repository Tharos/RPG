<?php

namespace Test;

require __DIR__ . '/../../bootstrap.php';

use Mockery;
use RPG\Exception\InvalidArgumentException;
use RPG\Exception\NotEnoughCreditsException;
use RPG\Game\Item;
use RPG\Game\Player;
use Tester\Assert;
use Tester\TestCase;



class PlayerTest extends TestCase
{

	public function testReceiveCredits()
	{
		$player = new Player('A');

		Assert::same(Player::CREDITS_DEFAULT, $player->getCredits());

		$player->receiveCredits(50);

		Assert::same(Player::CREDITS_DEFAULT + 50, $player->getCredits());
	}



	public function testReceiveCreditsException()
	{
		$player = new Player('A');

		Assert::throws(function () use ($player) {
			$player->receiveCredits(-50);
		}, InvalidArgumentException::class);
	}



	public function testBuyItem()
	{
		$playerA = new Player('A');
		$playerB = new Player('B');

		$item = Mockery::mock(Item::class)
			->shouldReceive('getPrice')->andReturn(50)->getMock()
			->shouldReceive('getOwner')->andReturn($playerB)->getMock()
			->shouldReceive('changeOwner')->atLeast()->once()->getMock();

		Assert::same(Player::CREDITS_DEFAULT, $playerA->getCredits());

		$playerA->buyItem($item);

		Assert::same(Player::CREDITS_DEFAULT - 50, $playerA->getCredits());
		Assert::same(Player::CREDITS_DEFAULT + 50, $playerB->getCredits());
	}



	public function testBuyItemException()
	{
		$player = new Player('A');

		$item = Mockery::mock(Item::class)
			->shouldReceive('getPrice')->andReturn(150)->getMock();

		Assert::throws(function () use ($player, $item) {
			$player->buyItem($item);
		}, NotEnoughCreditsException::class);
	}



	public function testAddItemException()
	{
		$player = new Player('A');

		$item = Mockery::mock(Item::class)
			->shouldReceive('isReleased')->andReturn(FALSE)->getMock();

		Assert::throws(function () use ($player, $item) {
			$player->addItem($item);
		}, InvalidArgumentException::class, "Cannot add item that isn't released.");
	}



	public function testRemoveItemException()
	{
		$player = new Player('A');

		$item = Mockery::mock(Item::class)
			->shouldReceive('isReleased')->andReturn(FALSE)->getMock();

		Assert::throws(function () use ($player, $item) {
			$player->removeItem($item);
		}, InvalidArgumentException::class, "Cannot remove item that isn't released.");
	}



	protected function tearDown()
	{
		parent::tearDown();
		Mockery::close();
	}

}



(new PlayerTest)->run();


