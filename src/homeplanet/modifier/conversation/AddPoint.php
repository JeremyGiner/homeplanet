<?php
namespace homeplanet\modifier\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\part\ConversationContext;

class AddPoint {
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
		$aState = $oContext->conversation->getState();
		
		$iCharIndex = $oContext->conversation->getCharacterIndex( $oContext->character );
		
		$aState['point'][ $iCharIndex ][ $this->_iPointIndex ] += $this->_iValue;
		
		$oContext->conversation->setState( $aState );
	}
}