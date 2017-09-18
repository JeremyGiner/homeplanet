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
	
	// TODO: move to context ?
	public function getBonus( ConversationContext $oContext ) {
		$iType = $oContext->expression->getTailRequireType();
		if( $iType === null )
			return 0;
		$iCharIndex = $oContext->getCharacterIndex( $oContext->character );
		
		return $oContext->conversation->getState()->getPoint( $iCharIndex, $iType );
	}
	
//_____________________________________________________________________________
// Process
	
	public function modify( ConversationContext $oContext ) {
		$oState = $oContext->conversation->getState();
		
		$iCharIndex = $oContext->conversation->getCharacterIndex( $oContext->character );
		
		$oState->addDebate( $iCharIndex, $this->_iValue + $this->getBonus( $oContext ) );
	}
}