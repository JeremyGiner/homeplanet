<?php
namespace homeplanet\tool;


use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\Tile;

class TileValidatorNaval implements ITileValidator {
	
	protected $_oWorldmap;
	
	public function __construct( Worldmap $oWorldmap ) {
		$this->_oWorldmap = $oWorldmap;
	}
	
	public function validate( Tile $oTile = null ) {
		
		if( $oTile === null ) return false;
		if( $oTile->getElevation() <= 0 ) return true;
		
		$bIsShore = false;
		
		$aTile = $this->_oWorldmap->getNeighbor( $oTile );
		
		foreach ( $aTile as $oTileNeighbor ) {
			if( $oTileNeighbor->getElevation() <= 0 ) {
				return true;
			}
		}
		
		return false;
	}
	
}