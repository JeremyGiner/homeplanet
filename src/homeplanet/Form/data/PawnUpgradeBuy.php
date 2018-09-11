<?php
namespace homeplanet\Form\data;

use homeplanet\Form\Buy;
use homeplanet\Entity\Player;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\Tile;
use Symfony\Component\Validator\Constraints as Assert;

class PawnUpgradeBuy extends Buy {
	
	/**
	 * @var Pawn
	 */
	private $_oPawn;
	
	/**
	 * @var Tile[]
	 */
	private $_aTile;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( Player $oPlayer, Pawn $oPawn, Worldmap $oWorldmap ) {
		parent::__construct($oPlayer, $oPawn->getType()->getValue() );
		
		$this->_oPawn = $oPawn;
		
		foreach ( $oPawn->getLocationAr() as $oLocation )
			$this->_aTile[] = $oWorldmap->getTileByLocation( $oLocation );
		
	}
	
//_____________________________________________________________________________
//	Accessor

	public function getPawn() {
		return $this->_oPawn;
	}
	
//_____________________________________________________________________________
//	Validator
	
	/**
	 * @Assert\IsTrue( message = "TODO" )
	 * @return boolean
	 */
	public function isTileCapacityValid() {
		
		//TODO : use validator
		// - multifield accessor requirement (ArrayTool agregate?)
		// - multifield accessor tile (ArrayTool agregate?)		
		// - combine (pair each lsit with one another, cartesian product? probably not)
		// - comparator < 
		foreach ( $this->_oPawn->getType()->getTileCapacityRequirementAr() as $oRequirement )
		foreach ( $this->_aTile as $oTile ) {
			if( 
				$oTile->getCapacityRemaining( $oRequirement->getType()->getId() )
				< 
				$oRequirement->getQuantity()
			) return false;
		}
		return true;
	}
}

