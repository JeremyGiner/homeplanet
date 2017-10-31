<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Pawn;
use homeplanet\Game;
use homeplanet\Entity\PawnFactory;
use homeplanet\tool\Perlin;
use homeplanet\Entity\TradeRouteFactory;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Player;
use homeplanet\Form\BuildingBuy;
use homeplanet\Form\BuildingBuyForm;
use homeplanet\Form\TradeRouteCreationForm;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Tests\ButtonTest;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use homeplanet\Form\LocationType;
use homeplanet\Form\EntityTypeChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\ProductionType;

/**
 *
 */
class TradeRouteController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	/**
	 * @Route("/trade-route", name="trade_route")
	 */
	public function mainAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );

		// Case : no player associated
		$oPlayer = $this->_oGame->getPlayer( $this->getUser()->getId() );
		if( $oPlayer == null )
			return $this->redirect( $this->generateUrl('player_create') );
		
		$oEntityManager = $this->getDoctrine()->getManager();
		
		$oUser = $this->getUser();
		
		// Get location
		$oLocation = $this->_oLocation;
		
		// Check game
		$oGame = $this->_oGame;
		//_____________________________
		//	Create traderoute
		$aGameView = $this->_createView($this->_oGame, $this->_oLocation);
		
		//TODO : form data validation
		$oFormTradeRouteCreation = $this->createFormBuilder(null,[])
			->add('location_pickup', LocationType::class, [
				'label' => 'Pick-up location',
				'game' => $oGame,
				'empty_data' => $oLocation,
			])
			->add('location_dropoff', LocationType::class, [ 
				'label' => 'Drop-off location',
				'game' => $oGame,
				'empty_data' => $oLocation,
			])
			->add('prodtype',EntityType::class,[
					'class' => ProductionType::class,
					'label' => 'Cargo type',
					'choice_label' => 'ressource.label',
					'query_builder' => function (EntityRepository $er) {
				        return $er->createQueryBuilder('prodtype')
				        	->join('prodtype._aEntityType', 'entitytype')
				        	->join('prodtype._oRessource', 'ressource')
							->where('entitytype._iId = 10'/* trade route */);
				    },
			])
			->add('submit',SubmitType::class,['label'=>'Create'])
			->getForm();
		$oFormTradeRouteCreation->handleRequest( $oRequest );
		if( $oFormTradeRouteCreation->isSubmitted() && $oFormTradeRouteCreation->isValid() ) {
			
			$oData = $oFormTradeRouteCreation->getData();
			
			// Build entity
			$a = (new TradeRouteFactory())->create(
					$oGame,
					$oUser,
					$oData['location_pickup'],
					$oData['location_dropoff'],
					$oData['prodtype']
			);
			$oGame->addEntity( $a['entity'], $a['addOn'] );
				
			return $this->redirect( $this->generateUrl('play') );
		}
		
		//_____________________________
		// Render game
		//$oGameViewFactory = $this->_gameViewFactory_get( $oGame, $oContext );
		
		return $this->render( 
			'page/page_form.html.twig', 
			[
				'user' => $this->getUser(),
				'title' => 'Create trade route',
				'form' => $oFormTradeRouteCreation->createView(),
				//'gameview' => $this->_createView($oGame, $oLocation),
			]
		);
	}
	
	
	
//_____________________________________________________________________________
//	Accessor

	
	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
