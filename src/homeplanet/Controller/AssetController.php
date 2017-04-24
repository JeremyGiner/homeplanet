<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\User;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Pawn;
use homeplanet\Game;
use homeplanet\Entity\PawnFactory;
use homeplanet\Form\TradeRouteFactory;
use homeplanet\Form\TradeRouteCreationForm;
use homeplanet\Entity\Player;
use homeplanet\Form\BuildingBuy;
use homeplanet\Form\BuildingBuyForm;
use homeplanet\Form\MerchantCreationForm;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Form\StepType;
use homeplanet\Form\MultistepType;
use homeplanet\Form\MultistepFormHandler;
use Symfony\Component\Serializer\Serializer;
use homeplanet\Serializer\Normalizer\DoctrineEntityNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

/**
 * @Route("/asset")
 */
class AssetController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	/**
	 * Display assets by location
	 * @Route("", name="asset")
	 */
	public function mainAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oEntityManager = $this->getDoctrine()->getManager();
		
		$oUser = $this->getUser();
		
		// Get location
		$oLocation = $this->_oLocation;
		
		// Check game
		$oGame = $this->_oGame;
		
		$oPlayer = $oGame->getPlayer();
		
		//_____________________________
		// Render
		
		$aPawnByLocation = $this->_oGame->getPawnAr_byPlayer_indexLocation($oPlayer);
		
		// Get ressource flux by location
		//TODO: remove code repetition
		$aFluxByLocation = [];
		foreach( $oGame->getPawnRepo()->getPawnAr_byPlayer($oPlayer) as $oPawn ) {
			foreach ( $oPawn->getProductionAr() as $oProd ) {
				
				foreach( $oProd->getProdInputAr() as $oProdInput ) {
					
					$sLocation = (string)$oProdInput->getLocation();
					
					// init location
					if( !isset($aFluxByLocation[$sLocation]) )
						$aFluxByLocation[$sLocation] = [];
					
					$oRessource = $oProdInput->getType()->getRessource();
					
					if( $oRessource->isNatural() )
						continue;
					
					// Get ressrouce id
					$iRessId = $oRessource->getId();
					
					// Filter credit (sell/buy)
					if( $iRessId == 1 )
						continue;
					
					// Init flux at location
					if( !isset( $aFluxByLocation[$sLocation][$iRessId] ) )
						$aFluxByLocation[$sLocation][$iRessId] = 0;
					
					// Substract prod input value
					$aFluxByLocation[$sLocation][$iRessId] -= $oProdInput->getQuantity();
				}
				
				$sLocation = (string)$oProd->getLocation();
				
				// init location
				if( !isset($aFluxByLocation[$sLocation]) )
					$aFluxByLocation[$sLocation] = [];
				
				// Get ressrouce id
				$iRessId = $oProd->getType()->getRessource()->getId();
				
				// Filter credit (sell/buy)
				if( $iRessId == 1 )
					continue;
				
				// Init flux at location
				if( !isset( $aFluxByLocation[$sLocation][$iRessId] ) ) 
					$aFluxByLocation[$sLocation][$iRessId] = 0;
				
				// Add prod value
				$aFluxByLocation[$sLocation][$iRessId] += $oProd->getQuantity();
			}
		}
		

		// Filter flux null
		foreach ( $aFluxByLocation as $sLocation => $aFlux )
		foreach ( $aFlux as $iRessId => $iValue ) {
			if( $aFluxByLocation[$sLocation][$iRessId] == 0 )
				unset($aFluxByLocation[$sLocation][$iRessId]);
		}
		
		
		return $this->render( 
			'homeplanet/page/asset.html.twig', 
			[
				'user' => $this->getUser(),
				'gameview' => $this->_createView($oGame, $oLocation),
				'aPawnByloc' => $aPawnByLocation,
				'aFluxByLocation' => $aFluxByLocation,
			]
		);
	}
	
	/**
	 * @Route("/{id}", name="asset_view", requirements={"id": "\d+"})
	 */
	public function assetViewAction( $id, Request $oRequest  ) {
		$this->_handleRequest($oRequest);
		$oEntityManager = $this->getDoctrine()->getManager();
	
		$oUser = $this->getUser();
		$oGame = $this->getGame();
		$oEntity = $oGame->getPawnRepo()->find( $id );
	
		if( $oEntity == null )
			throw('invalid entity id');
	
		return $this->render(
				'homeplanet/page/entityView.html.twig',
				[
						'date' => \date('d/m/Y H:i:s'),
						'user' => $this->getUser(),
						'gameview' => [
								'entity' => $oEntity,
								'player' => $oGame->getContextPlayer(),
								'game' => $oGame,
						],
				]
		);
	
	}
	
	/**
	 * @Route("/create", name="asset_create")
	 */
	public function createAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oUser = $this->getUser();
		$oGame = $this->_oGame;
		$oLocation = $this->_oLocation;
		
		//_____________________________
		// Form join Build
			
		$oData = new BuildingBuy(
				$this->_oLocation,
				$this->_oGame->getPawnType(2),
				$this->_oGame->getPlayer()
		);
		
		$oFormBuild = $this->createForm(BuildingBuyForm::class, $oData, 
				['gameview' => $this->_createView($oGame, $oLocation),] );
		
		$oFormBuild->handleRequest( $oRequest );
		if( $oFormBuild->isSubmitted() && $oFormBuild->isValid() ) {
		
			// User join room
			//var_dump( $oFormBuild->getData() );
			/* @var $oData BuildingBuy */
			$oData = $oFormBuild->getData();
				
			// Pay
			$oData->getPlayer()->setCredit(
					$oData->getPlayerCreditNew()
			);
				
			// Build entity
			$oFactory = new PawnFactory(
					$oData->getPawnType(),
					[
							'oPlayer' => $oGame->getPlayer(),
							'oLocation' => $oData->getLocation(),
					]
			);
				
			$a = $oFactory->create();
			$oGame->addPawn( $a['entity'], $a['addOn'] );
				
			return $this->redirect( $this->generateUrl('asset') );
		}
		
		// Render
		
		return $this->render(
				'homeplanet/page/game_form.html.twig',
				[
						'title' => 'Buy asset',
						'user' => $this->getUser(),
						'gameview' => $this->_createView($oGame, $oLocation),
						'form' => $oFormBuild->createView(),
				]
		);
	}
	
	/**
	 * @Route("/transproute-create", name="transproute_create")
	 */
	public function createTranspRouteAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oUser = $this->getUser();
		$oGame = $this->_oGame;
		$oLocation = $this->_oLocation;
		
		$oData = new TradeRouteFactory();
		$oData
			->setPlayer( $oGame->getPlayer() )
			->setLocationBegin($oLocation);
		
		// Create serializer
		$oSerializer = new Serializer([
			new DoctrineEntityNormalizer($oGame->getEntityManager()),
			new ObjectNormalizer(null,null,null, new ReflectionExtractor()),
			//new PropertyNormalizer(null,null,null, new ReflectionExtractor()),
		],[
			new JsonEncoder(),				
		]);
		
		// Commun option
		$a = [
			'gameview' => $this->_createView($oGame, $oLocation),
			'repo' => $oGame->getEntityManager()->getRepository(ProductionType::class),
		];
		
		//$oRequest->getSession()->remove('multitstep.data');
		$oStepHandler = new MultistepFormHandler( $oRequest->getSession() );
		$oStepHandler->setSerializer( $oSerializer, TradeRouteFactory::class );
		
		$oData = $oStepHandler->getData( $oData );
		
		$oForm = $this->createForm(TradeRouteCreationForm::class,$oData,[
			'game' => $this->_oGame,
			'step' => $oStepHandler->getStep(),
			'repo' => $oGame->getPawnRepo(),
		]+$a);
		
		$oForm->handleRequest( $oRequest );
		
		$oStepHandler->handleForm( $oForm );
		
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
			
			
			if( $oForm->has('confirm') && $oForm->get('confirm')->isClicked() ) {
				$oStepHandler->reset();
				/* @var $oFactory TradeRouteFactory */
				$oFactory = $oForm->getData();
				$a = $oFactory->create( $oGame );
				$oGame->addPawn($a['entity']);
				
				return $this->redirect( $this->generateUrl('asset') );
			}
			
			$oForm = $this->createForm(TradeRouteCreationForm::class,$oForm->getData(),[
				'game' => $this->_oGame,
				'step' => $oStepHandler->getStep(),
			]+$a);
		}
		
		return $this->render(
				'homeplanet/page/game_form.html.twig',
				[
						'title' => 'Create transporter route',
						'user' => $this->getUser(),
						'form' => $oForm->createView(),
						'gameview' => $a['gameview'],
				]
		);
	}
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
