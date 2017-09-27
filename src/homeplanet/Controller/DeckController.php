<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use homeplanet\Entity\Deck;

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
	
	
	
//_____________________________________________________________________________
// Sub-routine


	
}

