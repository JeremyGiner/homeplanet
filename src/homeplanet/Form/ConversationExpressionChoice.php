<?php
namespace homeplanet\Form;

use homeplanet\Entity\Expression;
use homeplanet\Entity\Character;
use homeplanet\Entity\Conversation;
use Doctrine\ORM\EntityManager;

class ConversationExpressionChoice {
	
	/**
	 * 
	 * @var Conversation
	 */
	private $_oConversation;
	
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
	
	public function __construct( 
			Conversation $oConversation,
			Character $oCharacter, 
			Expression $oExpression = null 
	) {
		$this->_oConversation = $oConversation;
		$this->_oCharacter = $oCharacter;
		$this->setExpression($oExpression);
	}
	
//_____________________________________________________________________________
// Accessor
	
	public function getExpression() {
		return $this->_oExpression;
	}
	
	public function getExpressionAr( EntityManager $em ) {
		$a = $this->_oConversation->getHand( $this->_oCharacter );
		return $em->getRepository(Expression::class)->find($a);
		//return $this->_oCharacter->getExpressionAr();
	}
	
//_____________________________________________________________________________
// Modifier
	
	public function setExpression( $oExpression ) {
		$this->_oExpression = $oExpression;
		return $this;
	}
	
	
	
	// TODO validate cost
}