<?php
namespace homeplanet\Entity\attribute;

use homeplanet\Game;
use homeplanet\tool\pathfinder\PathfinderWorldmap;
use homeplanet\tool\pathfinder\GetNeighborByValidator;
use homeplanet\tool\pathfinder\GetDifficultyDefault;
use homeplanet\tool\pathfinder\IsEndReachedByMaxHeat;
use homeplanet\tool\TileValidatorLand;
use homeplanet\tool\TileValidatorNaval;

class Transporter {
	
	/**
	 *
	 * @var Pathfinder
	 */
	protected $_oPathfinder;
	
	/**
	 * @var string
	 */
	protected $_sType;
	
	/**
	 * @var int
	 */
	protected $_iRange;
	
//_____________________________________________________________________________
//	Constructor

	public function __construct( array $aParam = [] ) {
		$this->_iRange = intval( $aParam[1] );
		$this->_sType = $aParam[0];
	}
	
//_____________________________________________________________________________
//	Accessor
	
	
	public function getTileValidator() {
		return $this->_sType == 'land' ? 
			new TileValidatorLand() : 
			new TileValidatorNaval( $oWorldmap )
		;
	}
	
	/**
	 * 
	 * @return PathfinderWorldmap
	 */
	function getPathfinder() {
		if( $this->_oPathfinder === null ) {
			
			// TODO: pass in construtor somehow
			$oWorldmap = Game::getInstance()->getWorldmap();
			$this->_oPathfinder = new PathfinderWorldmap(
				$oWorldmap, 
				new GetNeighborByValidator( $oWorldmap, $this->getTileValidator() ), 
				new GetDifficultyDefault(), 
				new IsEndReachedByMaxHeat( $this->_iRange -1 ) //$this->_oPawn->getAttribute() )
			);
			//$this->_oPathfinder->propagate( $this->_oLocationStart->__toString() );
		}
		return $this->_oPathfinder;
	}
}