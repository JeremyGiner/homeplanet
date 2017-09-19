<?php
namespace homeplanet\tool\conversation;


use homeplanet\Entity\Conversation;
use homeplanet\Entity\Character;
use homeplanet\Entity\Expression;
use homeplanet\Entity\part\ConversationContext;

class NpcBrain {
	
	/**
	 * 
	 * @param Conversation $oConversation
	 * @param Character $oCharacter
	 * @param Expression[] $aDeck
	 * @throws \Exception
	 * @return NULL|\homeplanet\Entity\int
	 */
	static public function chooseConversationExpression( 
		Conversation $oConversation,
		Character $oCharacter,
		array $aDeck
	) {
		
		$aExpressionId = $oConversation->getHand( $oCharacter );
		
		$aExpression = [];
		$oContext = new ConversationContext($oConversation, $oCharacter);
		foreach( $aExpressionId as $id ) {
			if( ! isset( $aDeck[ $id ] ) )
				throw new \Exception('Can not find #'.$id.' in deck, deck must be Expression[] indexed by id');
			
			if( $aDeck[ $id ]->getRequirement()->validate( $oContext ) )
				$aExpression[] = $aDeck[ $id ];
		}
		
		if( empty( $aExpression ) )
			return null;
		
		$k = \array_rand($aExpression);
		
		return $aExpression[ $k ];
	}
}