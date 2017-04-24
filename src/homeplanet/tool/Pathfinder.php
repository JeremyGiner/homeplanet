<?php
namespace homeplanet\tool;

/**
 * 
 */
class Pathfinder {
	
	/**
	 * @var mixed[]
	 */
	protected $_aMap;
	
	protected $_aPath;
	protected $_aHeat;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( array $aMap ) {
		
	}
	
//_____________________________________________________________________________
//	Accessor

	public function getHeatMap() {
		return $this->_aPath;
	}
	
	public function getHeatMap() {
		return $this->_aHeat;
	}
	
//_____________________________________________________________________________
//	
	
	abstract public function getNeighbor( $sCoordonate );
	
	abstract public function getDifficulty( $sFrom, $sTo );

//_____________________________________________________________________________
//	Process
	

	/**
	 * return result upon reaching any ends
	 */
	public function _path( array $aMap, $sBegin, array $aEnd ) {
	
		$aPath = [];
		$aHeatMap = [ $sBegin => 0.0 ];
		$aToDiscover = [ $sBegin ];
	
		while( !empty($aToDiscover) ) {
			$sDiscovering = array_shift($aToDiscover);
	
			//var_dump($sDiscovering);
	
			// Case : end reach
			if( in_array($sDiscovering,$aEnd) )
				return [
						'path' => $aPath,
						'heatmap' => $aHeatMap,
						'begin' => $sBegin,
						'end' => $sDiscovering,
				];
	
				// Get child
				$aChild = $this->getNeighbor($aMap,$sDiscovering);
	
				// Process children
				foreach( $aChild as $sCoord ) {
	
					// Case : undiscovered
					if( !isset($aPath[$sCoord]) )
						$aToDiscover[] = $sCoord;
						
					$fPrevHeat = isset($aHeatMap[$sCoord])?$aHeatMap[$sCoord]:null;
						
					$fNewHeat = $aHeatMap[$sDiscovering]
					+ 1
					+ $this->getDifficulty($aMap,$sDiscovering,$sCoord);
						
					// Case : previous parent have lower heat
					if(
							$fPrevHeat != null &&
							$fPrevHeat <= $fNewHeat
					)
						continue;
						
					// Mark child
					$aPath[$sCoord] = $sDiscovering;
					$aHeatMap[$sCoord] = $fNewHeat;
						
					//var_dump($aHeatMap[$sCoord]);
						
					// DEBUG
					if( $aHeatMap[$sCoord] <= $aHeatMap[$sDiscovering] )
						throw new \Exception('invalid heat');
				}
		}
		return null;
	}
	
//_____________________________________________________________________________
//	Sub-routine
	
	abstract public function _stopCondition() {
		
	}
	
	
	
}
