<?php
namespace homeplanet\modifier\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\part\ConversationContext;

class GivePoint {
	/**
	 * @var interger
	 */
	private $_iValue;
	
	/**
	 * @var interger
	 */
	private $_iPointIndex;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( $iType, $iValue ) {
		$this->_iPointIndex = $iType;
		$this->_iValue = $iValue;
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getType() {
		return $this->_iPointIndex;
	}
	
	public function getValue() {
		return $this->_iValue;
	}
	
//_____________________________________________________________________________
// Process

	public function modify( ConversationContext $oContext ) {
		
		$iCharIndex = $oContext->conversation->getOpponentIndex( $oContext->character );
		
		$oState = $oContext->conversation->getState();
		$oState->addPoint($iCharIndex, $this->_iPointIndex, $this->_iValue );
		
	}
}