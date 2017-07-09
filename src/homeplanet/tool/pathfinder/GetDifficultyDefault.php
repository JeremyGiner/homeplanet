<?php
namespace homeplanet\tool\pathfinder;

use phpDocumentor\Reflection\Types\Callable_;
use homeplanet\tool\ITileValidator;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\attribute\Location;
/**
 * 
 */
class GetDifficultyDefault {
	
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( ) {
	}
	
//_____________________________________________________________________________
//	

	public function __invoke( Pathfinder $oPathfinder, $sDiscovering, $sCoordChild, $sBegin ) {
		return 0;
	}
	
	
	
}
