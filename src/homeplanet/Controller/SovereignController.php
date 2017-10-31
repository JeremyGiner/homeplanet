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
use homeplanet\Form\Buy;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Tests\ButtonTest;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use homeplanet\Form\EntityTypeChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\Sovereign;
use homeplanet\Entity\Relationship;
use homeplanet\Entity\RelationshipType;
use homeplanet\Entity\RelationshipModifier;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;

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
