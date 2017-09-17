<?php
namespace homeplanet\modifier\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\part\ConversationContext;

class AddTail {
	
	/**
	 * @var interger[]
	 */
	private $_aPointIndex;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $aType ) {
		$this->_aPointIndex = $aType;
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getTypeAr() {
		return $this->_aPointIndex;
	}
	
//_____________________________________________________________________________
// Process

	public function modify( ConversationContext $oContext ) {
		$oState = $oContext->conversation->getState()->addTail( $aTypeFilter );
	}
}