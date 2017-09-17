<?php
namespace homeplanet\validator\conversation;

use homeplanet\Entity\Conversation;
use homeplanet\Entity\Character;
use homeplanet\Entity\part\ConversationContext;

class TailRequire /*implements IConversationValidator*/ {
	
	
	/**
	 * @var interger
	 */
	private $_iPointIndex;
	
//_____________________________________________________________________________
	
	public function __construct( $iType ) {
		$this->_iPointIndex = $iType;
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getValueCurrent( ConversationContext $oContext ) {
		return $oConversation->getState()->getPoint( 
			$oContext->getOpponentIndex(),
			$this->_iPointIndex
		);
	}
	
	public function getType() {
		return $this->_iPointIndex;
	}
	
	
//_____________________________________________________________________________
// Process
	
	public function validate( ConversationContext $oContext ) {
		return ! in_array( $this->getType(), $oContext->conversation->getState()->getTail() );
	}
}