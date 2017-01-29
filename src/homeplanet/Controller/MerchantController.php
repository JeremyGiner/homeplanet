<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Symfony\Component\HttpFoundation;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Session;
use homeplanet\Entity\attribute\Location;
use homeplanet\Game;
use homeplanet\entity\EntityFactory;
use homeplanet\Entity\attribute\homeplanet\Entity\attribute;
use homeplanet\Form\TradeRouteCreationForm;
use homeplanet\entity\TradeRouteFactory;
use homeplanet\Entity\MerchantFactory;
use homeplanet\Entity\Ressource;
use homeplanet\Form\MerchantCreationForm;
use homeplanet\Form\LocationType;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Form\ProductionTypeType;
use Doctrine\ORM\EntityRepository;

/**
 *
 */
class MerchantController extends BaseController {
	

//_____________________________________________________________________________
//	Action
	
	/**
	 * @Route("/merchant", name="merchant")
	 */
	public function mainAction( Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		$oGame = $this->_oGame;
		$oLocation = $this->_oLocation;
		
		/*
		$oFormCreate = $this->createForm(
				MerchantCreationForm::class,
				['location' => $oLocation ],
				['game' => $oGame, 'gameview' => [
					'player' => $oGame->getContextPlayer(),
					'chunk' => $oGame->getWorldmap()->getChunk(0, 0),
					'location' => $oLocation,
					'zoom' => 0,
					'game' => $oGame,
					'map' => $oGame->getWorldmap(),
					'entityAr' => $oGame->getEntityAr_byLocation($oLocation),
				]  ]
		);*/
		
		$aGameView = $this->_createView($oGame, $oLocation);
		
		$oMerchantFactory = new MerchantFactory($oGame);
		$oMerchantFactory->user = $this->getUser();
		$oMerchantFactory->location = $this->_oLocation;
		
		$oFormCreate = $this->createFormBuilder($oMerchantFactory)
			->add('location',LocationType::class,['gameview'=>$aGameView,])
			->add('productionType',EntityType::class,[
					'class' => ProductionType::class,
					'choice_label' => 'ProdInputTypeAr[0].ressource.label',
					'query_builder' => function (EntityRepository $er) {
				        return $er->createQueryBuilder('prodtype')
				        	->join('prodtype._aEntityType', 'entitytype')
				        	->join('prodtype._aProdInputType', 'prodinputtype')
				        	->join('prodinputtype._oRessource', 'ressource')
							->where('entitytype._iId = 4'/* merchant */);
				    },
			])
			->add('submit', SubmitType::class,['label'=>'Create'])
			->getForm();
		$oFormCreate->handleRequest( $oRequest );
		
		if( $oFormCreate->isSubmitted() && $oFormCreate->isValid() ) {
			
			/* @var $oMerchantFactory MerchantFactory */
			$oMerchantFactory = $oFormCreate->getData();
			
			$a = $oMerchantFactory->create();
			$oGame->addEntity( $a['entity'], $a['addOn'] );
			
		}
		
		return $this->render(
			'homeplanet/page/merchant.html.twig',
			[
				'date' => \date('d/m/Y H:i:s'),
				'user' => $this->getUser(),
				'form_create' => $oFormCreate->createView(),
				'gameview' => $aGameView,
			]
		);
	}
	
//_____________________________________________________________________________
//	Form action
	
	/**
	 * @Route("/entity_delete", name="entity_delete")
	 */
	public function deleteAction( Request $oRequest ) {
		
		$this->_handleRequest($oRequest);
		
		$oUser = $this->getUser();
		$oGame = $this->getGame();
		
		$oEntManager = $this->getDoctrine()->getEntityManager();
		
		$aForm = $this->_getFormEntityDeleteAr( $oGame, $oUser );
		foreach ( $aForm as $oForm ) {
			
			// Skip unsubmited/invalid form
			$oForm->handleRequest( $oRequest );
			if( !$oForm->isSubmitted() || !$oForm->isValid() )
				continue;
			
			$iEntityId = $oForm->getData()['entity_id'];
			
			// Fast delete
			$oEntityRef = $oEntManager->getReference( Entity::class, $iEntityId );
			$oEntManager->remove( $oEntityRef );
			
			// Commit
			$oEntManager->flush();
			
			break;
		}
		return $this->redirect( $this->generateUrl('play') );
	}
	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
