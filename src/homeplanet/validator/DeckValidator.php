<?php
namespace homeplanet\validator;


use homeplanet\Entity\Deck;

class DeckValidator /*extends IValidator*/ {
	
	public function __construct( array $a ) {
		$this->_a = $a;
	}
	
	public function validate( Deck $o = null ) {
		
		return DeckValidator::STvalidate($o);
	}
	
	static public function STvalidate( Deck $o = null ) {
		
		if( $o === null ) return false;
		
		if( count( $o->getExpressionAr() ) != Deck::SIZE ) return false;
		
		return true;
	}
}