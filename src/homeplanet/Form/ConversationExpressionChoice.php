<?php
namespace homeplanet\Form;

use homeplanet\Entity\Expression;
use homeplanet\Entity\Character;

class ConversationExpressionChoice {
	
	/**
	 * 
	 * @var Character
	 */
	private $_oCharacter;
	
	/**
	 * @var Expression
	 */
	private $_oExpression;
	
//_____________________________________________________________________________
// Constructor
	
	public function __construct( Character $oCharacter, Expression $oExpression = null ) {
		$this->_oCharacter = $oCharacter;
		$this->setExpression($oExpression);
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getExpression() {
		return $this->_oExpression;
	}
	
	public function getExpressionAr() {
		return $this->_oCharacter->getExpressionAr();
	}
	
//_____________________________________________________________________________
// Modifier
	
	public function setExpression( $oExpression ) {
		$this->_oExpression = $oExpression;
		return $this;
	}
	
	
	
	// TODO validate cost
}