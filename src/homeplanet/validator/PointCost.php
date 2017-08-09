<?php
namespace homeplanet\validator;


use homeplanet\Entity\Conversation;

class PointCost implements IConversationValidator {
	
	/**
	 * @var Character
	 */
	private $_oCharacter;
	
	/**
	 * @var interger
	 */
	private $_iCost;
	
	/**
	 * @var interger
	 */
	private $_iPointIndex;
	
//_____________________________________________________________________________
	
	public function __construct( Character $oCharacter, $iType, $iCost ) {
		$this->_oCharacter = $oCharacter;
		$this->_iPointIndex = $iType;
		$this->_iCost = $iCost;
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getValueCurrent( Conversation $oConversation ) {
		return $oConversation->getState()
			[ $oConversation->getCharacterIndex( $this->_oCharacter ) ]
			[ $this->_iPointIndex ]
		;
	}
	
	public function getType() {
		return $this->_iPointIndex;
	}
	
	public function getValue() {
		return $this->_iCost;
	}
	
//_____________________________________________________________________________
// Process
	
	public function validate( Conversation $oConversation ) {
		return $this->getValueCurrent( $oConversation ) >= $this->_iCost;
	}
}