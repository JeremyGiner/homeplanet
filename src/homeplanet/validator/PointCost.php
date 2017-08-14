<?php
namespace homeplanet\validator;

use homeplanet\Entity\Conversation;
use homeplanet\Entity\Character;

class PointCost /*implements IConversationValidator*/ {
	
	/**
	 * @var interger
	 */
	private $_iCost;
	
	/**
	 * @var interger
	 */
	private $_iPointIndex;
	
//_____________________________________________________________________________
	
	public function __construct( $iType, $iCost ) {
		$this->_iPointIndex = $iType;
		$this->_iCost = $iCost;
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getValueCurrent( Conversation $oConversation, Character $oCharacter ) {
		return $oConversation->getState()
			['point']
			[ $oConversation->getCharacterIndex( $oCharacter ) ]
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
	
	public function validate( array $aContext ) {
		return $this->getValueCurrent( $aContext[0], $aContext[1] ) >= $this->_iCost;
	}
}