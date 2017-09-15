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
	public $responseTo;
	
//_____________________________________________________________________________
// Constructor
	
	public function __construct( 
			Conversation $oConversation, 
			Character $oCharacter, 
			Expression $oResponseTo = null
	) {
		$this->character = $oCharacter;
		$this->conversation = $oConversation;
		$this->responseTo = $oResponseTo;
	}
	
//_____________________________________________________________________________
// Accessor

	public function getCharacterIndex() {
		$this->conversation->getCharacterIndex( $this->character );
	}
	public function getOpponentIndex() {
		$this->conversation->getOpponentIndex( $this->character );
	}
}
