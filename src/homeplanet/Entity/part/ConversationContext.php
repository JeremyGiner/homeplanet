<?php
namespace homeplanet\Entity\part;

use homeplanet\Entity\Conversation;
use homeplanet\Entity\Character;
use homeplanet\Entity\Expression;

class ConversationContext {
	/**
	 * 
	 * @var Conversation
	 */
	public $conversation;
	
	/**
	 * 
	 * @var Character
	 */
	public $character;
	
	/**
	 * @var Expression
	 */
	public $expression;
	
	/**
	 * @var Expression
	 */
	public $responseTo;
	
//_____________________________________________________________________________
// Constructor
	
	public function __construct( 
			Conversation $oConversation, 
			Character $oCharacter, 
			Expression $oExpression = null,
			Expression $oResponseTo = null
	) {
		$this->character = $oCharacter;
		$this->conversation = $oConversation;
		$this->expression = $oExpression;
		$this->responseTo = $oResponseTo;
	}
	
//_____________________________________________________________________________
// Accessor

	public function getCharacterIndex() {
		return $this->conversation->getCharacterIndex( $this->character );
	}
	public function getOpponentIndex() {
		return $this->conversation->getOpponentIndex( $this->character );
	}
}
