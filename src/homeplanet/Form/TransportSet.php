<?php
namespace homeplanet\Form;

use Symfony\Component\Validator\Constraints as Assert;
use homeplanet\Game;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Pawn;
use homeplanet\tool\TileValidatorLand;
use homeplanet\tool\pathfinder\Pathfinder;
use homeplanet\tool\pathfinder\GetNeighborByValidator;
use homeplanet\tool\pathfinder\GetDifficultyDefault;
use homeplanet\tool\pathfinder\IsEndReachedByMaxHeat;
use homeplanet\Entity\attribute\ProductionType;
use Symfony\Component\Serializer\Annotation\Groups;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\attribute\Transporter;

/**
 * @Assert\GroupSequence({"TransportSet","step1"})
 */
class TransportSet {
	
	/**
	 * @Groups({"serialisable"})
	 * @var Pawn
	 */
	protected $_oPawn;
	
	/**
	 * @Groups({"serialisable"})
	 * @Assert\NotBlank(groups={"step1"})
	 * @var Location
	 */
	protected $_oLocationBegin;
	/**
	 * @Groups({"serialisable"})
	 * @Assert\NotBlank()
	 * @var Location
	 */
	protected $_oLocationEnd;
	
	/**
	 * @Groups({"serialisable"})
	 * @Assert\NotBlank(groups={"step1"})
	 * @var ProductionType
	 */
	protected $_oProductionType;
	
	
//_____________________________________________________________________________
//	Constructor
	/*
	public function __construct( Pawn $pawn, $locationBegin, $locationEnd ) {
		$this->_oPawn = $pawn;
		$this->_oLocationBegin = $locationBegin;
		$this->_oLocationEnd = $locationEnd;
	}
	*/
	
//_____________________________________________________________________________
//	Accessor

	public function getLocationBegin() {
		return $this->_oLocationBegin;
	}
	
	public function getLocationEnd() {
		return $this->_oLocationEnd;
	}
	
	public function getProductionType() {
		return $this->_oProductionType;
	}
	
	public function getPawn() {
		return $this->_oPawn;
	}
	
//_____________________________________________________________________________
//	Modifier
	
	public function setPawn( Pawn $o = null ) {
		$this->_oPawn = $o;
		return $this;
	}
	public function setLocationBegin( Location $o = null ) {
		$this->_oLocationBegin = $o;
		return $this;
	}
	public function setLocationEnd( Location $o = null ) {
		$this->_oLocationEnd = $o;
		return $this;
	}
	
	public function setProductionType( ProductionType $o = null ) {
		$this->_oProductionType = $o;
		return $this;
	}
	
//_____________________________________________________________________________
//	Factory
	
//_____________________________________________________________________________
//	Validation

	/**
	 * @Assert\IsTrue(
	 *     message="Invalid location",
	 *     groups={"step1"}
	 * )
	 */
	function isLocationBeginValid() {
		/* @var $oTransporter Transporter */
		$oTransporter = $this->getPawn()->getAttribute('transport');
		
		$oPathfinder = $oTransporter->getPathfinder();
		$oTile = $oPathfinder->getWorldmap()->getTileByLocation( $this->_oLocationBegin );
		
		return $oTransporter->getTileValidator()->validate( $oTile );
	}
	
	/**
	 * @Assert\IsTrue(
	 *     message="not enought money",
	 *     groups={"Buy"}
	 * )
	 */
	function isLocationValid() {
		if( $this->_oLocationEnd === null ) return false;
		$oPathfinder = $this->getPawn()->getAttribute('transport')->getPathfinder();
		$oPathfinder->propagate( $this->_oLocationBegin );
		$aMapping = $oPathfinder->getMapping();
		if( $aMapping === null )
			return false; 
		return in_array( $this->_oLocationEnd->__toString(), $aMapping );
	}
}
