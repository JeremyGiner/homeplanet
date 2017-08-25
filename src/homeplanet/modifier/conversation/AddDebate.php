<?php
namespace homeplanet\modifier\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\part\ConversationContext;

class AddDebate {
	/**
	 * @var interger
	 */
	private $_iValue;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $iValue ) {
		$this->_iValue = $iValue;
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getType() {
		return $this->_iCharacterIndex;
	}
	
	public function getValue() {
		return $this->_iValue;
	}
	
//_____________________________________________________________________________
// Process

	public function modify( ConversationContext $oContext ) {
		$oState = $oContext->conversation->getState();
		
		$iCharIndex = $oContext->conversation->getCharacterIndex( $oContext->character );
		
		$oState->addDebate( $iCharIndex, $this->_iValue );
		
		$oContext->conversation->setState( $oState );
	}
}