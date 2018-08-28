<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use homeplanet\Form\Buy;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use homeplanet\Entity\Sovereign;
use homeplanet\Entity\Relationship;
use homeplanet\Entity\RelationshipType;
use homeplanet\Entity\RelationshipModifier;

/**
 *
 */
class SovereignController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	/**
	 * @Route("/sovereign/{id}", name="sovereign")
	 */
	public function mainAction( Request $oRequest, $id ) {
		
		$this->_handleRequest( $oRequest );
		
		$oEntityManager = $this->getDoctrine()->getManager();
		/*
		$oConfig = $oEntityManager->getConfiguration();
		$oConfig->setMetadataDriverImpl(
		    new \Doctrine\ORM\Mapping\Driver\DatabaseDriver(
		        $oEntityManager->getConnection()->getSchemaManager()
		    )
		);
		$oConfig = $oEntityManager->getConnection()->getConfiguration();
		$oConfig->setFilterSchemaAssetsExpression('/^(post).*$/');
		$o = new DisconnectedClassMetadataFactory();
		$o->setEntityManager( $oEntityManager );
		var_dump( $o->getAllMetadata()[0] );
		exit();*/
		
		
		$oUser = $this->getUser();
		
		// Get location
		$oLocation = $this->_oLocation;
		
		// Check game
		$oGame = $this->_oGame;
		$gem = $oGame->getEntityManager();
		
		$oSovereign = $gem->find(Sovereign::class, $id);
		
		if( $oSovereign === null ) {
			return $this->redirect( $this->generateUrl('play'));
		}
		
		//_____________________________
		// Gift form
		
		$oForm = $this->createFormBuilder( new Buy($oGame->getPlayer(), 100) )
			->add('submit', SubmitType::class, ['label' => 'Gift' ])
			->getForm();
		
		$oForm->handleRequest( $oRequest );
		
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
			
			/* @var $oData Buy */
			$oData = $oForm->getData();
			
			// Pay
			$oData->getPlayer()->setCredit(
				$oData->getPlayerCreditNew()
			);
			
			// Create relationship modifier
			$gem->persist(new RelationshipModifier(
				$oGame->getPlayer(), 
				$oSovereign, 
				$gem->find(RelationshipType::class, 1)
			));
			
			$gem->flush();
			return $this->redirect( $this->generateUrl('sovereign',['id' => $id]) );
		}
		
		//_____________________________
		// Render
		
		return $this->render( 
			'homeplanet/page/printo.html.twig', 
			[
				'user' => $this->getUser(),
				'title' => 'Sovereign',
				'gameview' => $this->_createView($oGame, $oLocation),
				'o' => $oSovereign,
				'param' => [
					'form' => $oForm->createView(),
					'relationshipAr' => $gem->getRepository(Relationship::class)->findBy([
						'_oSovereign' => $id,
						'_oPlayer' => $oGame->getPlayer()->getId(),
					]),
				],
			]
		);
	}
	
	
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
