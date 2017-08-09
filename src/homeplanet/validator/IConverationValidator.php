<?php
namespace homeplanet\validator;


use homeplanet\Entity\Conversation;

interface IConversationValidator /* extends IValidator */ {
	public function validate( Conversation $oConversation );
}