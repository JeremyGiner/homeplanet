<?php
namespace homeplanet\Entity\part;

class ConversationTurnLog {
	
	/**
	 * @var int
	 */
	private $_iExpression0Id;
	/**
	 * @var int
	 */
	private $_iExpression1Id;
	
	/**
	 * @var boolean
	 */
	private $_bTail0Countered;
	
	/**
	 * @var boolean
	 */
	private $_bTail1Countered;
	
//_____________________________________________________________________________
// Constructor

	public function __construct( 
			$iExpression0Id, 
			$iExpression1Id, 
			$bTail0Countered,
			$bTail1Countered
	) {
		$this->_iExpression0Id = $iExpression0Id;
		$this->_iExpression1Id = $iExpression1Id;
		
		$this->_bTail0Countered = $bTail0Countered;
		$this->_bTail1Countered = $bTail1Countered;
		
	}
	
//_____________________________________________________________________________
// Accessor

	public function getExpression0Id() {
		return $this->_iExpression0Id;
	}
	public function getExpression1Id() {
		return $this->_iExpression1Id;
	}
	
	public function isTail0Countered() {
		return $this->_bTail0Countered;
	}
	public function isTail1Countered() {
		return $this->_bTail1Countered;
	}
	
	public function isTailCountered( $i ) {
		if( $i === 0 )
			return $this->_bTail0Countered;
		if( $i === 1 )
			return $this->_bTail1Countered;
		
		throw new \Exception();
	}
}