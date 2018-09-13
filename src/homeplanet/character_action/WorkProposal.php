<?php
namespace homeplanet\character_action;

use homeplanet\Entity\Character;
use homeplanet\Entity\CharacterHistory;
use homeplanet\Entity\Pawn;

class WorkProposal extends CharacterAction {
	
	protected $_oTarget;
	
	public function __construct( Character $oCharacter, Pawn $oTarget, $iTurn ) {
		$this->_oTarget = $oTarget;
		parent::__construct( $oCharacter, $iTurn );
	}
	
	public function __invoke() {
		!!!!
		// TODO : send proposal to house
		/*
		return [
			new CharacterHistory( 
				[$this->_oCharacter], 
				WorkProposal::class, 
				[ 
					'proposer' => $this->_oCharacter->getId(), 
					'workplace' => $this->_oTarget->getId(),
				],
				$this->_iTurn 
			),
		];*/
	}
}

