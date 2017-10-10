<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use homeplanet\Entity\Conversation;
use homeplanet\tool\conversation\NpcBrain;
use homeplanet\Form\ConversationExpressionChoice;
use homeplanet\Form\ConversationExpressionChoiceForm;
use homeplanet\Entity\part\ConversationContext;
use AppBundle\Tool\ArrayTool;

/**
 * @Route("/conversation")
 */
class ConversationController extends BaseController {
	
//_____________________________________________________________________________
//	Action
	
	/**
	 * 
	 * @Route("", name="character")
	 */
	public function mainAction() {
		
	}
	
	/**
	 * Display conversation
	 * @Route("/{id}", name="conversation_view", requirements={"id": "\d+"})
	 */
	public function viewAction( $id, Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		/* @var $oConversation Conversation */
		$oConversation = $this->getGame()->getEntityManager()->find( Conversation::class, $id );
		if( $oConversation == null ) throw $this->createNotFoundException('No conversation found');
		
		//TODO : check user access
		
		if( $oConversation->getWinner() !== null )
			return $this->_resultAction($oConversation);
		
		//_____________________________
		// Create form
		
		$oExpressionChoice = new ConversationExpressionChoice(
				$oConversation,
				$oConversation->getCharacter0(),
				$oConversation->getCharacter0()->getDeck()->getExpressionAr()[1]
		);
		$oFormExpression = $this->createForm(
				ConversationExpressionChoiceForm::class,
				$oExpressionChoice,
				[
						'conversation_context' => new ConversationContext(
								$oConversation,
								$oConversation->getCharacter0()
						),
						'em' => $this->getGame()->getEntityManager(),
				]
		);
		
		$oFormExpression->handleRequest( $oRequest );
		if( $oFormExpression->isSubmitted() && $oFormExpression->isValid() ) {
			$repo = $this->getGame()->getExpressionRepo();
			$aDeck1 = array_map( function( $id ) use ( $repo ) { return $repo->find($id); } , $oConversation->getState()->getDeck1() );
			$aDeck1 = ArrayTool::STindexBy($aDeck1, 'id',true);
			$oConversation->processExpression(
					$oExpressionChoice->getExpression(),
					NpcBrain::chooseConversationExpression(
							$oConversation, 
							$oConversation->getCharacter1(), 
							$aDeck1
					)
			);
			$this->getGame()->getEntityManager()->flush();
				
			return $this->redirect( $this->generateUrl('conversation_view',['id' => $oConversation->getId()]) );
		}
		
		//_____________________________
		// Render
		
		return $this->render(
			'homeplanet/page/conversation.html.twig',
			[
				'gameview' => $this->_createView($this->_oGame, $this->_oLocation),
				'conversation' => $oConversation,
				'form' => $oFormExpression->createView(),
				'expressionAr' => ArrayTool::STindexBy(
					\array_merge(
						$oConversation->getCharacter0()->getDeck()->getExpressionAr(),
						$oConversation->getCharacter1()->getDeck()->getExpressionAr()
					),
					'id',
					true
				),
			]
		);
	}
	
	
	
//_____________________________________________________________________________
// Sub-routine

	/**
	 * Handle end of the conversation, summarize 
	 */
	private function _resultAction( Conversation $oConversation ) {
		
		// Get reward
		$sReward = $oConversation->getReward();
		
		// Give reward
		switch( $sReward ) {
			case 'meet' : 
				$em = $this->getGame()->getEntityManager();
				$this->getGame()->getPlayer()->getCharacter()
					->addAcquaintance($oConversation->getCharacter1());
				$em->remove( $oConversation );
				$em->flush();
			break;
		}
		
		// Get type
		$sType = null;
		switch( $sReward ) {
			case 'meet' : 
			default:
				$sType = $sReward;
		}
		
		// Get link "next" from reward
		$sLinkNext = $this->generateUrl('overview');
		switch( $sReward ) {
			case 'meet' : $sLinkNext = $this->generateUrl('character_view',['id' => $oConversation->getCharacter1()->getId()]); break;
		}
		
		
		return $this->render(
			'homeplanet/page/conversation_result.html.twig',
			[
				'gameview' => $this->_createView($this->_oGame, $this->_oLocation),
				'conversation' => $oConversation,
				'type' => $sType,
				'link_next' => $sLinkNext,
			]
		);
	}

	
}

