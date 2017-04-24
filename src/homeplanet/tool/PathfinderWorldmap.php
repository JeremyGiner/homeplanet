<?php
namespace homeplanet\tool;

/**
 * 
 */
class PathfinderWorldmap extends Pathfinder {
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( array $aMap ) {
		
	}
	
//_____________________________________________________________________________
//	
	
	public function getNeighbor( $sCoordonate ) {
	
		$a = explode(':',$sCoordonate);
		$x = intval($a[0]);
		$y = intval($a[1]);
	
		$aCoord = [
				($x+1).':'.$y,
				($x-1).':'.$y,
				$x.':'.($y+1),
				$x.':'.($y-1),
		];
	
		$aNeighbor = [];
		foreach( $aCoord as $sCoord )
			if( isset($this->_aMap[$sCoord]) )
				$aNeighbor[] = $sCoord;
			return $aNeighbor;
	}
	
	public function getDifficulty( $sFrom, $sTo ) {
		$aMap = $this->_aMap;
		
		if( $aMap[$sTo]>$aMap[$sFrom] )
			return 100*($aMap[$sTo]-$aMap[$sFrom]);
		else if( $aMap[$sTo]==$aMap[$sFrom] )
			return 1;
		// Debug
		if(($aMap[$sFrom]-$aMap[$sTo]) >= 1)
			throw new \Exception('qdsqd');
	
		return 1 - ($aMap[$sFrom]-$aMap[$sTo]);
	}
	
}
