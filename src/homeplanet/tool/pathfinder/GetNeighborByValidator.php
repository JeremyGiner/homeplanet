<?php
namespace homeplanet\tool\pathfinder;

use phpDocumentor\Reflection\Types\Callable_;
use homeplanet\tool\ITileValidator;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\attribute\Location;
/**
 * 
 */
class GetNeighborByValidator {
	
	/**
	 * 
	 * @var Worldmap
	 */
	protected $_oWorldmap;
	/**
	 * 
	 * @var ITileValidator
	 */
	protected $_oValidator;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( Worldmap $oWorldmap, ITileValidator $oValidator ) {
		$this->_oValidator = $oValidator;
		$this->_oWorldmap = $oWorldmap;
	}
	
//_____________________________________________________________________________
//	

	public function __invoke( Worldmap $oWorldmap, $sCoordonate ) {
		$a = $this->_getNeighbor($sCoordonate);
		
		$aNeighbor = [];
		foreach( $a as $sCoord ) {
			
			$oLocation = Location::getFromString($sCoord);
			$oTile = $this->_oWorldmap->getTileByLocation($oLocation);
			if( $this->_oValidator->validate( $oTile ) )
				$aNeighbor[] = $sCoord;
		}
		return $aNeighbor;
	}
	
//_____________________________________________________________________________
//	
	


//_____________________________________________________________________________
//	Process
	
	
//_____________________________________________________________________________
//	Sub-routine

	private function _getNeighbor( $sCoordonate ) {
		
		$a = explode(':',$sCoordonate);
		$x = intval($a[0]);
		$y = intval($a[1]);
	
		
		$aCoord = [
				($x+1).':'.$y,
				($x-1).':'.$y,
				$x.':'.($y+1),
				$x.':'.($y-1),
		];
		
		return $aCoord;
	}
	
	
}
