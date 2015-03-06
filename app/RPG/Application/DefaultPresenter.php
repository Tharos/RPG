<?php

namespace RPG\Application;

use Nette\Application\UI\Presenter;
use RPG\Game\Control\BuyItemControl;
use RPG\Game\Control\IBuyItemControlFactory;
use RPG\Game\Players;
use RPG\Game\PurchaseDetails;



class DefaultPresenter extends Presenter
{

	/**
	 * @var IBuyItemControlFactory
	 * @inject
	 */
	public $buyItemControlFactory;

	/**
	 * @var Players
	 * @inject
	 */
	public $players;



	public function renderDefault()
	{
		$this->template->players = $this->players->getPlayersOverview();
		$this->template->messages = $this->players->getMessages();
	}



	/**
	 * @return BuyItemControl
	 */
	protected function createComponentBuyItemControl()
	{
		$buyItemControl = $this->buyItemControlFactory->create();

		$buyItemControl->onItemBoughtByPlayer[] = function (PurchaseDetails $purchaseDetails) {
			$this->flashMessage('Player ' . $purchaseDetails->getNewOwner() . ' successfuly bought item ' . $purchaseDetails->getItem() . ' from player ' . $purchaseDetails->getOldOwner() . '.', 'success');
			$this->redirect('this');
		};

		return $buyItemControl;
	}

}
