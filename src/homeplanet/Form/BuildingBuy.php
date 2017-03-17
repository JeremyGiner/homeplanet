<?php
namespace homeplanet\Form;

use homeplanet\Entity\PawnType;
use Symfony\Component\Validator\Constraints as Assert;
use homeplanet\Entity\Player;
use homeplanet\Entity\attribute\Location;


class BuildingBuy {
	
	/**
	 * @var PawnType
	 */
	protected $_oPawnType;
	protected $_oLocation;
	/**
	 * @var Player
	 */
	protected $_oPlayer;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $oLoc, PawnType $oPawnType, Player $oPlayer ) {
		$this->_oLocation = $oLoc;
		$this->_oPawnType = $oPawnType;
		$this->_oPlayer = $oPlayer;
	}
	
//_____________________________________________________________________________
//	Accessor

	function getPawnType() {
		return $this->_oPawnType;
	}
	
	function getPlayer() {
		return $this->_oPlayer;
	}
	
	function getLocation() {
		return $this->_oLocation;
	}
	
//_____________________________________________________________________________
//	Modifier
	
	function setPawnType( $o ) {
		$this->_oPawnType = $o;
	}
	
	function setLocation( $o ) {
		$this->_oLocation = $o;
	}

//_____________________________________________________________________________
//	Validation

	/**
	 * @Assert\GreaterThanOrEqual(
	 *     value = 0,
	 *     message = "not enought money"
	 * )
	 */
	function getPlayerCreditNew() {
		return $this->_oPlayer->getCredit() - $this->_oPawnType->getValue();
	}
}
