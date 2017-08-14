<?php
namespace homeplanet\Entity\part;

use homeplanet\Entity\Conversation;
use homeplanet\Entity\Character;

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
	
	public function __construct( Conversation $oConversation, Character $oCharacter ) {
		$this->character = $oCharacter;
		$this->conversation = $oConversation;
	}
}