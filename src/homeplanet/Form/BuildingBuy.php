<?php
namespace homeplanet\Form;

use homeplanet\entity\EntityType;
use Symfony\Component\Validator\Constraints as Assert;
use homeplanet\Entity\Player;
use homeplanet\Entity\attribute\Location;


class BuildingBuy {
	
	/**
	 * @var EntityType
	 */
	protected $_oEntityType;
	protected $_iLocationX;
	protected $_iLocationY;
	/**
	 * @var Player
	 */
	protected $_oPlayer;
	
//_____________________________________________________________________________
//	Constructor
	
	function __construct( $iLocX, $iLocY, EntityType $oEntityType, Player $oPlayer ) {
		$this->_iLocationX = $iLocX;
		$this->_iLocationY = $iLocY;
		$this->_oEntityType = $oEntityType;
		$this->_oPlayer = $oPlayer;
	}
	
//_____________________________________________________________________________
//	Accessor

	function getEntityType() {
		return $this->_oEntityType;
	}
	
	function getLocationX() {
		return $this->_iLocationX;
	}
	
	function getLocationY() {
		return $this->_iLocationY;
	}
	
	function getPlayer() {
		return $this->_oPlayer;
	}
	
	function getLocation() {
		return new Location( 
			$this->getLocationX(), 
			$this->getLocationY() 
		);
	}
	
//_____________________________________________________________________________
//	Modifier
	
	function setEntityType( $o ) {
		$this->_oEntityType = $o;
	}
	
	function setLocationX( $i ) {
		$this->_iLocationX = $i;
	}
	
	function setLocationY( $i ) {
		$this->_iLocationY = $i;
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
		return $this->_oPlayer->getCredit() - $this->_oEntityType->getValue();
	}
}
