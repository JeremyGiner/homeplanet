<?php
namespace homeplanet\tool;


use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\Tile;

class TileValidatorLand implements ITileValidator {
	
	public function __construct() {
		
	}
	
	
	public function validate( Tile $oTile = null ) {
		if( $oTile === null ) return false;
		return $oTile->getElevation() > 0;
	}
	
}