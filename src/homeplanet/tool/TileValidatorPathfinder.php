<?php
namespace homeplanet\tool;

use homeplanet\Entity\Tile;

class TileValidatorPathfinder implements ITileValidator {
	
	private $_oTileRef;
	
	/**
	 *  @var Pathfinder 
	 */
	private $_oPathfinder;
	
	public function __construct( Tile $oTileRef, $oWorldmap, $oPathfinder ) {
		$this->_oTileRef = $oTileRef;
		$this->_oPathfinder = $oPathfinder;
		
		$this->_oPathfinder->_path(
				$aMap, 
				$this->_oTileRef->getLocation(), 
				[]	// no end
		);
	}
	
	public function validate( Tile $oTile = null ) {
		if( $oTile === null ) return false;
		return 
			$oTile->getLocation()->getDist($this->_oTileRef->getLocation()) 
			<= $this->_iRange;
	}
}