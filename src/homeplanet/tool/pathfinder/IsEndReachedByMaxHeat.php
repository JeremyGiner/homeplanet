<?php
namespace homeplanet\tool\pathfinder;

use phpDocumentor\Reflection\Types\Callable_;
use homeplanet\tool\ITileValidator;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\attribute\Location;
/**
 * 
 */
class IsEndReachedByMaxHeat {
	
	protected $_iMax;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $iMax ) {
		$this->_iMax = $iMax;
	}
	
//_____________________________________________________________________________
//	

	public function __invoke( Pathfinder $oPathfinder, $sDiscovering, $sBegin ) {
		
		return $oPathfinder->getHeat($sDiscovering) > $this->_iMax;
	}
	
	
	
}
