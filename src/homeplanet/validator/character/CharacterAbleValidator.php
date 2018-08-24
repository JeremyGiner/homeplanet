<?php
namespace homeplanet\validator\character;

use homeplanet\Entity\Character;
use homeplanet\tool\F;

class CharacterAbleValidator {
	
	
	private $_iTurn;
	
	const AGE_ABLE_MIN = 3;
	const AGE_ABLE_MAX = 20;
	
	public function __construct( $iTurn ) {
		$this->_iTurn = $iTurn;
	}
	
	public function validate( Character $oCharacter ) {
		self::STvalidate( $this->_iTurn, $oCharacter );
	}
	
	static public function STvalidate( $iTurn, $oCharacter ) {
		
		return F::isBetween(
			$oCharacter->getDateCreated(),
			$iTurn - self::AGE_ABLE_MAX,
			$iTurn - self::AGE_ABLE_MIN
		);
	}
}

