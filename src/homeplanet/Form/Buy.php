<?php
namespace homeplanet\Form;

use homeplanet\Entity\PawnType;
use Symfony\Component\Validator\Constraints as Assert;
use homeplanet\Entity\Player;
use homeplanet\Entity\attribute\Location;


class Buy {
	
	/**
	 * @var Player
	 */
	protected $_oPlayer;
	
	protected $_iCost;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( Player $oPlayer, $iCost ) {
		$this->_iCost = $iCost;
		$this->_oPlayer = $oPlayer;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	function getPlayer() {
		return $this->_oPlayer;
	}
	
	function getCost() {
		return $this->_iCost;
	}
	
//_____________________________________________________________________________
//	Modifier
	
//_____________________________________________________________________________
//	Validation

	/**
	 * @Assert\GreaterThanOrEqual(
	 *     value = 0,
	 *     message = "not enought money",
	 *     groups={"Buy"}
	 * )
	 */
	function getPlayerCreditNew() {
		return $this->_oPlayer->getCredit() - $this->getCost();
	}
}
