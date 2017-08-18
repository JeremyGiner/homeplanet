<?php
namespace homeplanet\Entity\part;

use homeplanet\Entity\Expression;

class ConversationState {
	
	/**
	 * Pair of expression played indexed by turn then by character index
	 * @var int[][]
	 */
	private $_aLog;
	
	/**
	 * Indexed by character index then by point type (persuade(0), coerce(1), ...)
	 * @var int[][]
	 */
	private $_aPoint;
	
//______________________________________________________________________________
// Constructor
	
	public function __construct() {
		$this->_aPoint = [
			0 => [ 0, 0, 0, 0 ],
			1 => [ 0, 0, 0, 0 ],
		];
		$this->_aLog = [];
	}
	
//______________________________________________________________________________
// Accessor

	public function getPointAr() {
		return $this->_aPoint;
	}
	public function getPoint( $iCharacterIndex, $iIndex ) {
		return $this->_aPoint[ $iCharacterIndex ][ $iIndex ];
	}
	
	public function getLog() {
		return $this->_aLog;
	}
	
//______________________________________________________________________________
// Modifier

	public function setPoint( $iCharacterIndex, $iIndex, $iValue ) {
		$this->_aPoint[ $iCharacterIndex ][ $iIndex ] = min( max( $iValue, 0 ), 5 );
		return $this;
	}
	public function addPoint( $iCharacterIndex, $iIndex, $iValue ) {
		return $this->setPoint(
			$iCharacterIndex, 
			$iIndex, 
			$this->getPoint($iCharacterIndex, $iIndex) + $iValue 
		);
	}
	
	public function addLog( Expression$oExp0, Expression $oExp1 ) {
		$this->_aLog[] = [ $oExp0->getId(), $oExp1->getId() ];
		return $this;
	}
}