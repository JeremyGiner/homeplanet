<?php
namespace homeplanet\validator\conversation;

use homeplanet\Entity\Conversation;
use homeplanet\Entity\Character;
use homeplanet\Entity\part\ConversationContext;

class OpponentPointRequire /*implements IConversationValidator*/ {
	
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
	
	public function getValueCurrent( ConversationContext $oContext ) {
		return $oConversation->getState()->getPoint( 
			$oContext->getOpponentIndex(),
			$this->_iPointIndex
		);
	}
	
	public function getType() {
		return $this->_iPointIndex;
	}
	
	public function getValue() {
		return $this->_iCost;
	}
	
//_____________________________________________________________________________
// Process
	
	public function validate( ConversationContext $oContext ) {
		return $this->getValueCurrent( $oContext ) >= $this->_iCost;
	}
}