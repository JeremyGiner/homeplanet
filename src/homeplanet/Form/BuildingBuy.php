<?php
namespace homeplanet\Form;

use homeplanet\Entity\PawnType;
use Symfony\Component\Validator\Constraints as Assert;
use homeplanet\Entity\Player;
use homeplanet\Entity\attribute\Location;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
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
	 * @var PawnType
	 */
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
	
	function getCost() {
		return $this->getPawnType()->getValue();
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
