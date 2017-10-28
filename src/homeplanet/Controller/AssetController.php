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
use homeplanet\Entity\attribute\Production;
use homeplanet\Form\TradeRouteFactory;
use homeplanet\Form\TradeRouteCreationForm;
use homeplanet\Entity\Player;
use homeplanet\Form\Buy;
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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\PawnType;
use AppBundle\Tool\ArrayTool;
use homeplanet\Entity\City;
use homeplanet\Form\TransportSet;
use homeplanet\Form\TransportSetForm;
use Symfony\Component\HttpFoundation\RedirectResponse;
use homeplanet\Serializer\SerializerDefaultDoctrine;

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
		
		$oPawnManager = $this->getDoctrine()->getManager();
		
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

		// Filter flux at 0
		foreach ( $aFluxByLocation as $sLocation => $aFlux )
		foreach ( $aFlux as $iRessId => $iValue ) {
			if( $aFluxByLocation[$sLocation][$iRessId] == 0 )
				unset($aFluxByLocation[$sLocation][$iRessId]);
		}
		
		$aLocation = [];
		$aCoordonate = [];
		foreach ( $aPawnByLocation as $sLocation => $aPawn ) {
			$oLocation = Location::getFromString($sLocation);
			$aLocation[ $sLocation ] = $oLocation;
			$aCoordonate[] = [$oLocation->getX(),$oLocation->getY()];
		}
		
		
		$q = $oGame->getEntityManager()->createQueryBuilder()
			->select('city')
			->from(City::class,'city')
		;
		
		$i = -1;
		$a = [];
		foreach( $aCoordonate as $coordonate ) {
			$q
				->orWhere('city._x = ?'.++$i.' AND city._y = ?'.++$i)
				//->setParameter('x'.$key, $oLocation->getX())
				//->setParameter('y'.$key, $oLocation->getY())
			;
			$a[] = $coordonate[0];
			$a[] = $coordonate[1];
		}
		$q->setParameters($a);
		
		$aCity = $q->getQuery()->getResult();
		$aCity = ArrayTool::STindexBy($aCity, 'location.string');
		
		// Load overcrowd
		$aOvercrowd = $oGame->getOvercrowdRepo()->findByCoordonateAr($a);
		
		return $this->render( 
			'homeplanet/page/asset.html.twig', 
			[
				'user' => $this->getUser(),
				'gameview' => $this->_createView($oGame, $oLocation),
				'aPawnByloc' => $aPawnByLocation,
				'aFluxByLocation' => $aFluxByLocation,
				'aLocation' => $aLocation,
				'worldmap' => $oGame->getWorldmap(),
				'aCity' => $aCity,
			]
		);
	}
	
	/**
	 * @Route("/{id}", name="asset_view", requirements={"id": "\d+"})
	 */
	public function assetViewAction( $id, Request $oRequest  ) {
		$this->_handleRequest($oRequest);
		$oPawnManager = $this->getDoctrine()->getManager();
	
		$oUser = $this->getUser();
		$oGame = $this->getGame();
		
		/* @var $oPawn Pawn */
		$oPawn = $oGame->getPawnRepo()->find( $id );
	
		if( $oPawn == null )
			return $this->redirect( $this->generateUrl('asset') );
		
		$bTransporter = $oPawn->getAttribute('transport') !== null;
		
		//_____________________________
		//	Form switch prod
		
		$oFormProd = null;
		$oFormProdRecap = null;
		$aProdType = $oPawn->getType()->getProdTypeAr();
		if( !$bTransporter && count( $aProdType ) > 1 ) {
			
			// TODO : form validation
			$oFormProd = $this->createFormBuilder( array() )
				->add('production_type', EntityType::class, [
					'class' => ProductionType::class,
					'label' => 'Production',
					'choice_label' => 'label',
					'choices' => $oPawn->getType()->getProdTypeAr(),
					/*
					'query_builder' => function (EntityRepository $er) use ($oPawn ){
						return $er->createQueryBuilder('prodtype')
							->join('prodtype._aPawnType', 'pawntype')
							->join('prodtype._oRessource', 'ressource')
							->where('pawntype._iId = '.$oPawn->getType()->getId());
					},*/
				])
				->add('submit',SubmitType::class,['label'=>'Change'])
				->getForm();
			
			$oFormProd->handleRequest( $oRequest );
			
			if( $oFormProd->isSubmitted() && $oFormProd->isValid() ) {
				//$oPawn->clearProduction();
				
				//$oGame->getEntityManager()->persist($oPawn);
				foreach ( $oPawn->getProductionAr() as $oProd ) {
					$oGame->getEntityManager()->remove($oProd);
				}
				$oProd = Production::create(
						$oPawn, 
						$oPawn->getLocationAr()[0], 
						$oFormProd->getData()['production_type']
				);
				$oPawn->addProduction( $oProd );
				$this->_oGame->updateProductionRatio($oProd);
				
				$oGame->getEntityManager()->flush();
				
				$oGame->getProductionRepo()->updateProduction();
				
				$this->addFlash('success', 'Production successfully changed.');
				
				//var_dump($oForm->getData()['production_type']);
				return $this->redirect( $oRequest->getUri() );
			}
		
		}
		
		if( $bTransporter ) {
			
			/* @var $oData TransportSet */
			$oData = new TransportSet();
			$oData
				->setPawn($oPawn)
				->setLocationBegin($this->_oLocation)
				->setLocationEnd(null)
			;
			
			// Commun option
			$a = [
					'gameview' => $this->_createView($this->_oGame, $this->_oLocation),
			];
			
			$oStepHandler = new MultistepFormHandler( 
					$oRequest->getSession(), 
					'multistep.transportset.'.$oPawn->getId() 
			);
			//$oStepHandler->reset();
			$oStepHandler->setSerializer( 
				new SerializerDefaultDoctrine( $this->_oGame->getEntityManager() ), 
				TransportSet::class 
			);
			$oStepHandler->setContext(array('groups' => array('serialisable')));
			
			$oData = $oStepHandler->getData( $oData );
			
			$oFormProd = $this->createForm(TransportSetForm::class,$oData,[
					'game' => $this->_oGame,
					'step' => $oStepHandler->getStep(),
			]+$a);
			
			$oFormProdRecap = $this->createForm(TransportSetForm::class,$oData,[
					'game' => $this->_oGame,
					'step' => $oStepHandler->getStep(),
					'isRecap' => true,
			]+$a);
			
			$oFormProd->handleRequest( $oRequest );
			
			if( $oStepHandler->handleForm( $oFormProd ) == true ) {
				return $this->redirect( $oRequest->getUri() );
			}
			
			if( $oFormProd->isSubmitted() && $oFormProd->isValid() ) {
				
				if( $oFormProd->has('confirm') && $oFormProd->get('confirm')->isClicked() ) {
					$oStepHandler->reset();
					
					// Update model
					$oData = $oFormProd->getData();
					$oPawn = $oData->getPawn();
	
					//$oGame->getEntityManager()->persist($oPawn);
					foreach ( $oPawn->getProductionAr() as $oProd ) {
						$this->_oGame->getEntityManager()->remove($oProd);
					}
					
					//$oPawn->resetLocation();
					foreach ( $oPawn->getPawnLocationAr() as $oPosition ) {
						$this->_oGame->getEntityManager()->remove($oPosition);
					}
					
					$this->_oGame->getEntityManager()->flush();
					
					$oPawn->addLocation( $oData->getLocationBegin() );
					$oPawn->addLocation( $oData->getLocationEnd() );
					
					$oProd = Production::createTransport(
							$oPawn,
							$oData->getLocationBegin(),
							$oData->getLocationEnd(),
							$oData->getProductionType()
					);
					$oPawn->addProduction( $oProd );
					
					//$this->_oGame->updateProductionRatio($oProd);
					
					$this->_oGame->getEntityManager()->flush();
					$this->_oGame->getProductionRepo()->updateProduction();
					
			
					return $this->redirect( $oRequest->getUri() );
				}
				
				$oFormProd = $this->createForm(TransportSetForm::class,$oFormProd->getData(),[
						'game' => $this->_oGame,
						'step' => $oStepHandler->getStep(),
				]+$a);
				
				return $this->redirect( $oRequest->getUri() );
			}
			
		}
		
		//_____________________________
		//	Form upgrade asset
		
		$oBuyUpgrade = new Buy($oGame->getPlayer(), $oPawn->getType()->getValue());
		$oFormUpgrade = $this->createNamedBuilder(
				'upgrade', 
				FormType::class, 
				$oBuyUpgrade
			)
			->add('submit',SubmitType::class,[
					'label' => 'Upgrade '.$oPawn->getType()->getValue(),
					'attr' => [
							'class' => 'btn-primary',
					], 
			])
			->getForm()
		;
			
		$oFormUpgrade->handleRequest( $oRequest );
		
		if( $oFormUpgrade->isSubmitted() && $oFormUpgrade->isValid() ) {
			$oBuyUpgrade->getPlayer()->setCredit( $oBuyUpgrade->getPlayerCreditNew() );
			
			// Update entity's grade and his production
			$oPawn->upgrade();
			foreach ( $oPawn->getProductionAr() as $oProduction ) {
				$oGame->updateProductionRatio($oProduction);
			}
			
			$oGame->getEntityManager()->flush();
			
			$oGame->getProductionRepo()->updateProduction();
			
			return $this->redirect( $oRequest->getUri() );
		}
		
		//_____________________________
		//	Form sell asset
		
		$oFormSell = $this->createNamedBuilder('sell')
			->add('submit',SubmitType::class,[
					'label' => 'Sell '.$oPawn->getType()->getValue(),
					'attr' => [
							'class' => 'btn-danger',
							'onclick' => 'return confirm("Are you sure?")',
					], 
			])
			->getForm()
		;
			
		$oFormSell->handleRequest( $oRequest );
		
		if( $oFormSell->isSubmitted() && $oFormSell->isValid() ) {
			$em = $oGame->getEntityManager();
			$oProdRepo = $oGame->getProductionRepo();
			
			// 
			foreach ( $oPawn->getProductionAr() as $oProd ) {
				
				foreach ( $oProdRepo->getSupplied($oProd) 
						as $oSupplied 
				) {
					$oSupplied->setNotUpdated();
				}
			}
			//
			$em->remove( $oPawn );
			$em->flush();
			
			$oProdRepo->updateProduction();
			
			return $this->redirect( $oRequest->getUri() );
		}
		
		//_____________________________
		
		
		return $this->render(
			'homeplanet/page/pawnView.html.twig',
			[
				'date' => \date('d/m/Y H:i:s'),
				'user' => $this->getUser(),
				'gameview' => [
						'entity' => $oPawn,
						'player' => $oGame->getContextPlayer(),
						'game' => $oGame,
				] + $this->_createViewMin($oGame, $this->_oLocation ),
				
				'form_delete' => $oFormSell->createView(),
				'form_upgrade' => $oFormUpgrade->createView(),
			] + ( $bTransporter ? [
				'form_prodtype_transporter' => $oFormProd->createView(),
				'form_prodtype_recap' => $oFormProdRecap->createView(),
			] : ( $oFormProd == null ? [] : [
				'form_prodtype' => $oFormProd->createView(),
			] ) )
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
		$oPlayer = $oGame->getPlayer();
		
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
			
			$oPawn = $a['entity'];
			$oGame->addPawn( $a['entity'], $a['addOn'] );
			
			$oGame->getProductionRepo()->updateProduction();
			
				
			return $this->redirect( $this->generateUrl('asset_view',['id'=>$oPawn->getId()]) );
		}
		
		//_____________________________
		//	Form buy contract
		
		$oBuyUpgrade = new Buy($oPlayer, $oPlayer->getContractPrice() );
		$oFormUpgrade = $this->createNamedBuilder(
					'buycontract',
					FormType::class,
					$oBuyUpgrade
			)
			->add('submit',SubmitType::class,[
					'label' => 'Upgrade contract',
					'attr' => [
							'class' => 'btn-primary',
					],
			])
			->getForm()
		;
			
		$oFormUpgrade->handleRequest( $oRequest );
		
		if( $oFormUpgrade->isSubmitted() && $oFormUpgrade->isValid() ) {
			$oBuyUpgrade->getPlayer()->setCredit( $oBuyUpgrade->getPlayerCreditNew() );
			
			$oPlayer->increaseContractMax();
			
			$oGame->getEntityManager()->flush();
				
			return $this->redirect( $oRequest->getUri() );
		}
		
		//_____________________________
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
