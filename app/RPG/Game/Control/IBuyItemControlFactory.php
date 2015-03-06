<?php

namespace RPG\Game\Control;



interface IBuyItemControlFactory
{

	/**
	 * @return BuyItemControl
	 */
	function create();

}
