<?php
namespace homeplanet\tool\pathfinder;

use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Worldmap;
/**
 * 
 */
class PathfinderWorldmap extends Pathfinder {
	
//_____________________________________________________________________________
//	Constructor
	/*
	public function __construct( $aMap ) {
		
	}
	*/
	
//_____________________________________________________________________________
//

	public function propagate($sBegin) {
		if( $sBegin instanceof Location )
			$sBegin = $sBegin->__toString();
		return parent::propagate($sBegin);
			
	}
	
//_____________________________________________________________________________
//	
	/**
	 * 
	 * @return Worldmap
	 */
	public function getWorldmap() {
		return $this->_aMap;
	}
	
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
		return 0;
		
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

// Land
	
// toward 1 goal
	protected function _stopConditionfd( $sDiscovering, $aEnd ) {
		
		return in_array($sDiscovering,$aEnd);
	}
	
// toward all goal
	protected function _stopConditiondd( $sDiscovering, $aEnd ) {
	
		//remove goal
		return empty( $aGoal );
	}
	
// range
	protected function _stopConditionqq( $sDiscovering, $aEnd ) {
		// Test heat
		
		return $range >= $heat;
	}
}
