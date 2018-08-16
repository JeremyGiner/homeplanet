<?php
namespace homeplanet\character_action;

use homeplanet\Entity\Character;
use homeplanet\Entity\CharacterHistory;

class WeddingProposal extends CharacterAction {
	
	protected $_oTarget;
	
	public function __construct( Character $oCharacter, Character $oTarget, $iTurn ) {
		$this->_oTarget = $oTarget;
		parent::__construct( $oCharacter, $iTurn );
	}
	
	public function __invoke() {
		
		// TODO : handle case proposal is rejected
		
		$this->_oCharacter->setMate( $this->_oTarget );
		$this->_oTarget->setMate( $this->_oCharacter );
		
		return [ new CharacterHistory( 
			[ 
				$this->_oCharacter, 
				$this->_oTarget, 
			], 
			CharacterHistory::WEDDING_PROPOSAL, 
			[
				'proposer' => $this->_oCharacter, 
				'proposed' => $this->_oTarget,
				'accepted' => true,
			], 
			$this->_iTurn 
		) ];
		
	}
}

