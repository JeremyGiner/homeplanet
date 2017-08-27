<?php
namespace homeplanet\modifier\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\part\ConversationContext;

class TakeLead {
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
	}
	
//_____________________________________________________________________________
// Accessor
	
	
//_____________________________________________________________________________
// Process

	public function modify( ConversationContext $oContext ) {
		$iCharIndex = $oContext->conversation->getCharacterIndex( $oContext->character );
		
		$oState = $oContext->conversation->getState();
		$oState->setCharacterLeading( $iCharIndex );
	}
}