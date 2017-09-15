<?php
namespace homeplanet\modifier\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\part\ConversationContext;

class Imitate {
	/**
	 * @var integer[]
	 */
	private $_aTypeFilter;
	
	/**
	 * Convertion array output indexed by input
	 * @var interger[]
	 */
	private $_aConvert;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( array $aTypeFilter = null, array $aConvert = null ) {
		$this->_iTypeFilter = $aTypeFilter;
		$this->_aConvert = $aConvert;
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getFilterAr() {
		return $this->_aTypeFilter;
	}
	public function getConvertAr() {
		return $this->_aConvert;
	}
//_____________________________________________________________________________
// Process

	public function modify( ConversationContext $oContext ) {
		$iCharIndex = $oContext->conversation->getCharacterIndex( $oContext->character );
		
		$oState = $oContext->conversation->getState();
		
		foreach( $oContext->responseTo->getEffectAr() as $oEffect ) {
			
			// Imitate only 
			if( get_class($oEffect) != AddPoint::class ) continue;
			
			/* @var $oEffect AddPoint */
			if( $this->_aTypeFilter !== null && in_array( $oEffect->getType(), $this->_aTypeFilter ) ) continue;
			
			$iType = $this->_aConvert == null ? 
				$oEffect->getType() :
				$this->_aConvert[ $oEffect->getType() ];
			
			$oState->addPoint($iCharIndex, $iType, $this->_iValue );
		}
	}
}