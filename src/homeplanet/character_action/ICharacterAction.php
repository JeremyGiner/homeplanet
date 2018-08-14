<?php
namespace homeplanet\character_action;

use homeplanet\Entity\Character;
use homeplanet\Entity\CharacterHistory;

interface ICharacterAction {
	
	/**
	 * @return Character
	 */
	public function getCharacter();
	
	/**
	 * @return CharacterHistory[]
	 */
	public function __invoke();
	
}

