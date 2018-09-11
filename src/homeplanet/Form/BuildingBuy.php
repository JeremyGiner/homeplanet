<?php
namespace homeplanet\Form;

use homeplanet\Entity\PawnType;
use Symfony\Component\Validator\Constraints as Assert;
use homeplanet\Form\ConstraintValidator as AcmeAssert;
use homeplanet\Entity\Player;
use homeplanet\Entity\Tile;

/**
 * @AcmeAssert\BuildingBuyTileCapacity
 * @Assert\GroupSequence({"BuildingBuy","after"})
 */
class BuildingBuy {
	
	/**
	 * @Assert\NotBlank(message="Select an asset")
	 * @var PawnType
	 */
	protected $_oPawnType;
	
	/**
	 * @Assert\NotBlank(message="Invalid location")
	 * @var Tile
	 */
	protected $_oTile;
	
	/**
	 * @var Player
	 */
	protected $_oPlayer;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( Tile $oTile, PawnType $oPawnType, Player $oPlayer ) {
		$this->_oTile = $oTile;
		$this->_oPawnType = $oPawnType;
		$this->_oPlayer = $oPlayer;
	}
	
//_____________________________________________________________________________
//	Accessor
	/**
	 * @return \homeplanet\Entity\PawnType
	 */
	function getPawnType() {
		return $this->_oPawnType;
	}
	
	function getPlayer() {
		return $this->_oPlayer;
	}
	function getTile() {
		return $this->_oTile;
	}
	
	function getLocation() {
		return $this->getTile()->getLocation();
	}
	
	function getCost() {
		return $this->getPawnType()->getValue();
	}
	
//_____________________________________________________________________________
//	Modifier
	
	function setPawnType( $o ) {
		$this->_oPawnType = $o;
	}
	
	function setTile( $oTile ) {
		$this->_oTile = $oTile;
	}

//_____________________________________________________________________________
//	Validation
	
	/**
	 * @Assert\GreaterThanOrEqual(
	 *     value = 0,
	 *     message = "Not enought money",
	 *     groups={"after"}
	 * )
	 */
	function getPlayerCreditNew() {
		
		// Quick fix for validation GroupSequence bug
		// TODO : use Group Sequence Providers
		if( $this->_oPawnType === null )
			return -1;
		
		
		return $this->_oPlayer->getCredit() - $this->getCost();
	}
	
	/**
	 * @Assert\GreaterThan(
	 *     value = 0,
	 *     message = "Not enought contract"
	 * )
	 */
	function getRemainingContract() {
		return $this->_oPlayer->getContractRemaining();
	}
	
}
