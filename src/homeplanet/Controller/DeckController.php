<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use homeplanet\Entity\Deck;
use homeplanet\Form\DeckForm;
use Doctrine\ORM\Tools\Pagination\Paginator;
use AppBundle\Tool\DoctrinePaginator;

/**
 * @Route("/deck")
 */
class DeckController extends BaseController {
	
//_____________________________________________________________________________
//	Action
	
	/**
	 * Allow user to :
	 * - view equipped deck
	 * - view other deck
	 * - change deck
	 * - link to deck build
	 * @Route("", name="deck")
	 */
	public function mainAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oGame = $this->getGame();
		
		$aExpression = $oGame->getExpressionRepo()->findAll();
		$aDeck = $oGame->getDeckRepo()->findAllCommun();
		
		$oCharacter = $this->getGame()->getPlayer()->getCharacter();
		
		//_____________________________
		$form = $this->createFormBuilder()
			->add( 'deck', EntityType::class, [ 'class' => Deck::class, 'choices' => $aDeck ] )
			->add( 'submit', SubmitType::class, [ 'label' => 'Equip' ] )
			->getForm()
		;
		
		// Render
		return $this->render('homeplanet/page/deck.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'deck_current' => $oCharacter->getDeck(),
			'deckAr' => $aDeck,
			'form_equip' => $form,
			'character' => $oCharacter,
		]);
	}
	
	/**
	 * @Route("/create", name="deck_create")
	 */
	public function createAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oGame = $this->getGame();
		
		$gem = $oGame->getEntityManager();
		
		$oCharacter = $this->getGame()->getPlayer()->getCharacter();
		
		$iPage = $oRequest->get('page',1);
		$iPage = max( 1, $iPage );
		
		$oQuery = $this->getGame()->getExpressionRepo()
			->createQueryBuilder('expression');
		
		
		$oPaginator = new DoctrinePaginator($oQuery, $iPage, 4);
		//$oPaginator = new Paginator( $oQuery );
		
		$aExpression = $oPaginator->getQuery()->getResult();
		
		//_____________________________
		// Form create
		
		$oFormCreate = $this->createForm(DeckForm::class, new Deck(), [
			'em' => $gem,
		] );
		
		$oFormCreate->handleRequest( $oRequest );
		
		if( $oFormCreate->isSubmitted() && $oFormCreate->isValid() ) {
			
			$gem->persist( $oFormCreate->getData() );
			$gem->flush();
			
			return $this->redirect($this->generateUrl('deck'));
		}
		
		//_____________________________
		// Render
		
		return $this->render('homeplanet/page/deck_create.html.twig', [
			'gameview' => $this->_createViewMin($this->_oGame, $this->_oLocation),
			'form_create' => $oFormCreate->createView(),
			'expressionAr' => $aExpression,
			'expression_paginator' => $oPaginator,
		]);
	}
	
	
//_____________________________________________________________________________
// Sub-routine


	
}

