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
	 * @var int
	 */
	private $_iCharacterLeadingId;
	/**
	 * @var int
	 */
	private $_iDebateIntensity;
	
//_____________________________________________________________________________
// Constructor

	public function __construct( 
			$iExpression0Id, 
			$iExpression1Id, 
			$iCharacterLeadingId,
			$iDebateIntensity
	) {
		$this->_iExpression0Id = $iExpression0Id;
		$this->_iExpression1Id = $iExpression1Id;
		$this->_iCharacterLeadingId = $iCharacterLeadingId;
		$this->_iDebateIntensity = $iDebateIntensity;
		
	}
	
//_____________________________________________________________________________
// Accessor

	public function getExpression0Id() {
		return $this->_iExpression0Id;
	}
	public function getExpression1Id() {
		return $this->_iExpression1Id;
	}
	public function getCharacterLeadingId() {
		return $this->_iCharacterLeadingId;
	}
	public function getDebateIntensity() {
		return $this->_iDebateIntensity;
	}
	
	
}