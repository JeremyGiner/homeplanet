<?php
namespace homeplanet\tool\pathfinder;

use phpDocumentor\Reflection\Types\Callable_;
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
	
	protected $_fnGetNeighbor;
	protected $_fnGetDifficulty;
	protected $_fnIsEndReached;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( 
			$oMap, 
			Callable $fnGetNeighbor,
			Callable $fnGetDifficulty,
			Callable $fnIsEndReached
	) {
		$this->_aMap = $oMap;
		$this->_aHeat = null;
		$this->_aPath = null;
		
		$this->_fnGetDifficulty = $fnGetDifficulty;
		$this->_fnGetNeighbor = $fnGetNeighbor;
		$this->_fnIsEndReached = $fnIsEndReached;
	}
	
//_____________________________________________________________________________
//	Accessor

	public function getPath( $sBegin, $aEnd ) {
		
		// Case: not processed
		if( $this->_aPath == null )
			return null;
		
		//TODO: return path
		
		return $this->_aPath;
	}
	
	public function getMapping() {
		return $this->_aPath;
	}
	
	public function getHeatMap() {
		return $this->_aHeat;
	}
	
	public function getHeat( $s ) {
		return isset( $this->_aHeat[$s] ) ? $this->_aHeat[$s] : null;
	}
	
//_____________________________________________________________________________
//	
	


//_____________________________________________________________________________
//	Process
	

	/**
	 * return result upon reaching any ends
	 */
	public function propagate( $sBegin ) {
	
		$aMap = $this->_aMap;
		
		$this->_aPath = [];
		$this->_aHeat = [ $sBegin => 0.0 ];
		$aPath = &$this->_aPath;
		$aHeatMap = &$this->_aHeat;
		
		$aToDiscover = [ $sBegin ];
	
		while( !empty($aToDiscover) ) {
			$sDiscovering = array_shift($aToDiscover);
	
			// Case : end reach
			if( call_user_func($this->_fnIsEndReached, $this, $sDiscovering, $sBegin ) ) {
				return [
						'path' => $aPath,
						'heatmap' => $aHeatMap,
						'begin' => $sBegin,
						'end' => $sDiscovering,
				];
			}
	
			// Get child
			$aChild = call_user_func($this->_fnGetNeighbor,$aMap,$sDiscovering);

			
			// Process children
			foreach( $aChild as $sCoord ) {

				// Case : undiscovered
				if( !isset($aPath[$sCoord]) )
					$aToDiscover[] = $sCoord;
					
				$fPrevHeat = isset($aHeatMap[$sCoord])?$aHeatMap[$sCoord]:null;
					
				$fNewHeat = $aHeatMap[$sDiscovering]
					+ 1
					+ call_user_func($this->_fnGetDifficulty, $this, $sDiscovering, $sCoord, $sBegin )
				;
				
				
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
	
	
}
