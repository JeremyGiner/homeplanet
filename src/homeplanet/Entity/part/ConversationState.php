<?php
namespace homeplanet\Entity\part;

use homeplanet\Entity\Expression;

class ConversationState {
	
	/**
	 * Pair of expression played indexed by turn then by character index
	 * @var ConversationTurnLog[]
	 */
	private $_aLog;
	
	/**
	 * Indexed by character index then by point type (persuade(0), coerce(1), ...)
	 * @var int[][]
	 */
	private $_aPoint;
	
	/**
	 * Current debate point (positive favor character0, negative favor character1)
	 * @var int
	 */
	private $_iDebate;
	
	/**
	 * Current debate intensity
	 * @var int
	 */
	private $_iDebateIntensity;
	
	/**
	 * Debate goal for character0
	 * @var int
	 */
	private $_iDebateGoal0;
	
	/**
	 * Debate goal for character1
	 * @var int
	 */
	private $_iDebateGoal1;
	
	/**
	 * Character index of the leading character
	 * @var int
	 */
	private $_iCharacterLeading;
	
//______________________________________________________________________________
// Constructor
	
	public function __construct() {
		$this->_aPoint = [
			0 => [ 0, 0, 0, 0 ],
			1 => [ 0, 0, 0, 0 ],
		];
		$this->_aLog = [];
		$this->_iDebate = 0;
		$this->_iCharacterLeading = null;
		$this->_iDebateIntensity = 0;
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
	
	public function getDebate() {
		return $this->_iDebate;
	}
	public function getDebateIntensity() {
		return $this->_iDebateIntensity;
	}
	public function getDebateGoal0() {
		return $this->_iDebateGoal0;
	}
	public function getDebateGoal1() {
		return $this->_iDebateGoal1;
	}
	
	public function getWinnerIndex() {
		if( $this->_iDebate >= $this->_iDebateGoal0 )
			return 0;
		if( $this->_iDebate <= -$this->_iDebateGoal1 )
			return 1;
		return null;
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
	
	public function setCharacterLeading( $iCharacterId ) {
		$this->_iCharacterLeading = $iCharacterId;
		return $this;
	}
	
	public function updateDebate() {
		if( $this->_iCharacterLeading === null ) return;
		
		$this->_iDebate += $this->getDebateIntensity();
		return $this;
	}
	
	public function addDebateIntensity( $iCharacterIndex, $iValue ) {
		$this->_iCharacterLeading = $iCharacterIndex;
		
		if( $this->_iCharacterLeading === null ) return;
		
		$this->_iDebate = abs( $this->_iDebate ) + $iValue;
		if( $iCharacterIndex === 1 )
			$this->_iDebate *= -1;
		
		return $this;
	}
	
	public function addLog(
		Expression $iExpression0,
		Expression $iExpression1
	) {
		$this->_aLog[] = new ConversationTurnLog(
				$iExpression0->getId(), 
				$iExpression1->getId(), 
				$this->_iCharacterLeading,
				$this->_iDebateIntensity
		);
		return $this;
	}
}