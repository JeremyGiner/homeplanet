<?php
namespace homeplanet\modifier\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\part\ConversationContext;

class Counter {
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
	}
	
//_____________________________________________________________________________
// Accessor
	
	
//_____________________________________________________________________________
// Process

	public function modify( ConversationContext $oContext ) {
		// Do nothing
		// Handled by conversation
	}
}