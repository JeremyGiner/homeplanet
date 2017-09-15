<?php
namespace homeplanet\modifier\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\part\ConversationContext;

class ChangeLead {
	
	const GIVE = 0;
	const TAKE = 1;
	const RESET = 2;
	
	private $_iModificationType;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $iModificationType ) {
		$this->_iModificationType = $iModificationType;
	}
	
//_____________________________________________________________________________
// Accessor
	
	
	public function getType() {
		return $this->_iModificationType;
	}
	
//_____________________________________________________________________________
// Process

	public function modify( ConversationContext $oContext ) {
		
		$iCharIndex = null;
		if( $this->_iModificationType === self::TAKE ) {
			$iCharIndex = $oContext->getCharacterIndex();
		} else if( $this->_iModificationType === self::GIVE ) {
			$iCharIndex = $oContext->getOpponentIndex();
		}
		
		$oContext->conversation->getState()->setCharacterLeading( $iCharIndex );
	}
}