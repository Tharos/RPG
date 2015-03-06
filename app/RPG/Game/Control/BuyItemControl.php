<?php

namespace RPG\Game\Control;

use Closure;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use RPG\Exception\IException;
use RPG\Game\Marketplace;
use RPG\Game\PurchaseDetails;



/**
 * @method onItemBoughtByPlayer(PurchaseDetails $purchaseDetails)
 */
class BuyItemControl extends Control
{

	/**
	 * @var Closure[]
	 */
	public $onItemBoughtByPlayer = [];

	/**
	 * @var Marketplace
	 */
	private $marketplace;



	/**
	 * @param Marketplace $marketplace
	 */
	public function __construct(Marketplace $marketplace)
	{
		parent::__construct();

		$this->marketplace = $marketplace;
	}



	public function render()
	{
		$this->template->render(__DIR__ . '/buyItemControl.latte');
	}



	/**
	 * @return Form
	 */
	protected function createComponentForm()
	{
		$form = new Form;

		$form->addSelect('buyer', 'Buyer', $this->marketplace->getPlayersList());

		$form->addSelect('item', 'Item', $this->marketplace->getItemsList());

		$form->addSubmit('buy', 'Buy');

		$form->onSuccess[] = function (Form $form) {
			$values = $form->getValues();

			try {
				$purchaseDetails = $this->marketplace->buyItemByPlayer($values->item, $values->buyer);
				$this->onItemBoughtByPlayer($purchaseDetails);
			} catch (IException $e) {
				// in real application we would better translate specific low-level exceptions to meaningfull messages
				$form->addError($e->getMessage());
			}
		};

		return $form;
	}

}
