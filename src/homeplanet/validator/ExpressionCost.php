<?php
namespace homeplanet\validator;


use homeplanet\Entity\Expression;
use homeplanet\Entity\Conversation;

class ExpressionCost /*extends IExpressionValidator*/ {
	
	/**
	 * @var Conversation
	 */
	private $_oConversation;
	
	public function __construct( Conversation $oConversation ) {
		$this->_oConversation = $oConversation;
	}
	
	public function validate( Expression $oExpression ) {
		return $oExpression->getRequirement()->validate( $this->_oConversation );
	}
}