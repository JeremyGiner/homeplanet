<?php
namespace homeplanet\Entity;
use homeplanet\Game;
use homeplanet\Entity\attribute\Location;

class WorldmapChunk {
	
	/**
	 * @var Game
	 */
	protected $_oGame;
	protected $_iRegionX, $_iRegionY;
	
	/**
	 * Array of entity indexed by location
	 * @var Entity[][]
	 */
	protected $_aEntityMapBuffer;
	
//______________________________________________________________________________
//	Constructor
	
	public function __construct( 
			$oGame, 
			$iRegionX, $iRegionY
	) {
		
		$this->_oGame = $oGame;
		$this->_aEntityMapBuffer = null;
		$this->_iRegionX = $iRegionX;
		$this->_iRegionY = $iRegionY;
	}
	
//______________________________________________________________________________
//	Accessor
	
	/**
	 * @param int $x
	 * @param int $y
	 * @return Entity[]
	 */
	public function getEntityAr_byLocation( Location $oLoc ) {
		$this->_updateEntityBuffer();
		return isset( $this->_aEntityMapBuffer[ (string)$oLoc ] ) ? $this->_aEntityMapBuffer[ (string)$oLoc ] : null ;
	}
	
//______________________________________________________________________________
//	Sub-routine
	
	private function _updateEntityBuffer() {
		if( $this->_aEntityMapBuffer != null )
			return;
		
		$this->_aEntityMapBuffer = [];
		
		$a = $this->_oGame->getEntityAr_byArea(
				$this->_iRegionY, 
				$this->_iRegionY + 13, 
				$this->_iRegionX, 
				$this->_iRegionX + 13
		);
		var_dump($a);
		foreach( $a as $oEntity )
			foreach( $oEntity->getLocationAr() as $oLocation )
				$this->_aEntityMapBuffer[ (string)$oLocation ][] = $oEntity;
		
	}
	
}