<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use homeplanet\Entity\Conversation;
use homeplanet\tool\conversation\NpcBrain;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
		
		//_____________________________
		// Create form
		
		$oExpressionChoice = new ConversationExpressionChoice(
				$oConversation,
				$oConversation->getCharacter0(),
				$oConversation->getCharacter0()->getExpressionAr()[1]
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
										$oConversation->getCharacter0()->getExpressionAr(),
										$oConversation->getCharacter1()->getExpressionAr()
								),
								'id',
								true
						),
				]
		);
	}
	
	
//_____________________________________________________________________________
// Sub-routine


	
}

