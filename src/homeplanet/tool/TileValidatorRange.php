<?php
namespace homeplanet\tool;

use homeplanet\Entity\Tile;

class TileValidatorRange implements ITileValidator {
	
	private $_oTileRef;
	private $_iRange;
	
	public function __construct( Tile $oTileRef, $iRange ) {
		$this->_oTileRef = $oTileRef;
		$this->_iRange = $iRange;
	}
	
	public function validate( Tile $oTile = null ) {
		if( $oTile === null ) return false;
		return 
			$oTile->getLocation()->getDist($this->_oTileRef->getLocation()) 
			<= $this->_iRange;
	}
}