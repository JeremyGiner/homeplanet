<?php
namespace homeplanet\character_action;

use homeplanet\Entity\Character;

abstract class CharacterAction implements ICharacterAction {
	
	protected $_iTurn;
	protected $_oCharacter;
	
	protected function __construct( Character $oCharacter, $iTurn ) {
		$this->_oCharacter = $oCharacter;
		$this->_iTurn = $iTurn;
	}
	
	public function getCharacter() {
		return $this->_oCharacter;
	}
	
	public function getTurn() {
		return $this->_iTurn;
	}
}

