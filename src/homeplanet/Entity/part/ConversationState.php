<?php
namespace homeplanet\Entity\part;

use homeplanet\Entity\Expression;

class ConversationState {
	
	/**
	 * Expression id
	 * Indexed by character index
	 * @var int[]
	 */
	private $_aDeck;
	
	/**
	 * Expression id
	 * Indexed by character index
	 * @var int[]
	 */
	private $_aHand;
	
	/**
	 * Expression id drawn indexed by turn then by character index
	 * @var int[][]
	 */
	private $_aLogDraw;
	
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
	
	/**
	 * Arrray of aspect type id forbidden to be played
	 * @var int[]
	 */
	private $_aTail;
	
//______________________________________________________________________________
// Constructor
	
	public function __construct(
		array $aDeck0,
		array $aHand0,
		array $aDeck1,
		array $aHand1
	) {
		$this->_iDebateGoal0 = 25;
		$this->_iDebateGoal1 = 25;
		
		$this->_aPoint = [
			0 => [ 0, 0, 0, 0 ],
			1 => [ 0, 0, 0, 0 ],
		];
		$this->_aLog = [];
		$this->_iDebate = 0;
		$this->_iCharacterLeading = null;
		$this->_iDebateIntensity = 0;
		
		$this->_aDeck = [
			0 => $aDeck0,
			1 => $aDeck1,
		];
		$this->_aHand = [
			0 => $aHand0,
			1 => $aHand1,
		];
		
		$this->_aLogDraw = [[
			0 => $aHand0,
			1 => $aHand1,
		]];
		
		
		
		$this->_aTail = [0,1,2,3];
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
	
	public function getHand( $iCharacterIndex ) {
		if( ! isset( $this->_aDeck[$iCharacterIndex] ) ) throw new \Exception();
		return $this->_aDeck[$iCharacterIndex];
	}
	public function getDeck1() {
		return $this->_aDeck[1];
	}
	public function getDeck0() {
		return $this->_aDeck[0];
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
	
	public function getCharacterLeading() {
		return $this->_iCharacterLeading;
	}
	
	/**
	 * Get character index of the winner, or null if there is no winner yet
	 * @return number|NULL
	 */
	public function getWinnerIndex() {
		if( $this->_iDebate >= $this->_iDebateGoal0 )
			return 0;
		if( $this->_iDebate <= -$this->_iDebateGoal1 )
			return 1;
		return null;
	}
	
	public function getTail() {
		return $this->_aTail;
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
	
	public function addTail( array $aTypeFilter ) {
		$this->_aTail = array_merge( $aTypeFilter, $this->_aTail );
		return $this;
	}
	
	public function setTail( array $aTypeFilter ) {
		$this->_aTail = $aTypeFilter;
		return $this;
	}
	
	public function setCharacterLeading( $iCharacterId ) {
		$this->_iCharacterLeading = $iCharacterId;
		return $this;
	}
	
	public function setHand0( array $a ) {
		$this->_aHand[0] = $a;
		return $this;
	}
	public function setHand1( array $a ) {
		$this->_aHand[1] = $a;
		return $this;
	}
	
	public function updateDebate() {
		if( $this->_iCharacterLeading === null ) return;
		
		$this->_iDebate += ( $this->_iCharacterLeading == 0 ) ?
			$this->getDebateIntensity() :
			-$this->getDebateIntensity();
		return $this;
	}
	
	public function addDebate( $iCharacterIndex, $iValue ) {
		$this->_iDebate += ( $iCharacterIndex == 0 ) ?
			$iValue :
			-$iValue;
		return $this;
	}
	
	public function addDebateIntensity( $iCharacterIndex, $iValue ) {
		$this->_iCharacterLeading = $iCharacterIndex;
		
		if( $this->_iCharacterLeading === null ) return;
		
		$this->_iDebateIntensity += $iValue;
		
		return $this;
	}
	
	public function addLog(
		$iExpression0,
		$iExpression1
	) {
		$this->_aLog[] = new ConversationTurnLog(
				$iExpression0, 
				$iExpression1, 
				$this->_iCharacterLeading,
				$this->_iDebateIntensity
		);
		
		return $this;
	}
}
