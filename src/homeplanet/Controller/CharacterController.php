<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use homeplanet\Entity\Character;

/**
 * @Route("/character")
 */
class CharacterController extends BaseController {
	
//_____________________________________________________________________________
//	Action
	
	/**
	 * 
	 * @Route("", name="character")
	 */
	public function mainAction() {
		
	}
	
	
	/**
	 * Display character's info
	 * @Route("/{id}", name="character_view", requirements={"id": "\d+"})
	 */
	public function viewAction( $id, Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		$oCharacter = $this->getGame()->getCharacterRepo()->find( $id );
		
		if( $oCharacter == null ) throw $this->createNotFoundException('No character found');
		
		// Form debate
		
		
		
		// Render
		return $this->render('homeplanet/page/character_view.html.twig', [
				'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
				'character' => $oCharacter,
		]);
	}
	
	/**
	 * Display character's info
	 * @Route("/acquaintance", name="character_acquaintance")
	 */
	public function acquaintanceAction( Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		$aAquaintance = $this->getGame()->getCharacterRepo()->getAcquaintance( $this->getGame()->getPlayer() );
	
		return $this->render('homeplanet/page/acquaintance.html.twig', [
				'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
				'characterList' => $aAquaintance,
		]);
	}
	
	/**
	 * 
	 * @Route("/travel", name="travel")
	 */
	public function travelAction( Request $oRequest ) {
		//TODO
		$this->_handleRequest( $oRequest );
		
		$oForm = $this->createFormBuilder([],['csrf_protection' => false])
			->setMethod('GET')
			->add( SubmitType::class, [ 'label' => 'Meet a random character' ] )
			->getForm()
		;
		$oForm->handleRequest( $oRequest );
		
		$aCharacter = null;
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
			$aCharacter = $this->_oGame->getCharacterRepo()->getRandomList( $this->_oLocation );
		}
		
		return $this->render('homeplanet/page/.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'characterList' => $aCharacter,
		]);
	}
	
	/**
	 * 
	 * @Route("/expression", name="character_expression")
	 */
	public function expressionAction( Request $oRequest ) {
		
		/*
# Update knowledge expression
INSERT IGNORE INTO knowledge ( knowledge.`id`,knowledge.`label`, knowledge.`type`, knowledge.reference) 
SELECT id+10000,' ','expression', id FROM expression
		 */
		
		$this->_handleRequest( $oRequest );
		
		$oExpressionRepo = $this->getGame()->getExpressionRepo();
		
		$aExpression = $oExpressionRepo->findAll();
		
		$aOwnership = $oExpressionRepo->getIdByPlayerOwnership( $this->getGame()->getPlayer()->getId() );
		
		$aDeck = $oExpressionRepo->getDeckByPlayer( $this->getGame()->getPlayer()->getId() );
		
		return $this->render('homeplanet/page/expression_list.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'expressionList' => $aExpression,
			'expressionOwnershipAr' => array_flip( $aOwnership ),
		]);
	}
}

