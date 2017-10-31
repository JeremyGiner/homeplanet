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
use homeplanet\Form\TradeRouteFactory;
use homeplanet\Form\TradeRouteCreationForm;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Player;
use homeplanet\Form\BuildingBuy;
use homeplanet\Form\BuildingBuyForm;
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
use homeplanet\Form\MultistepType;
use homeplanet\Form\MultistepFormHandler;
use Symfony\Component\Serializer\Serializer;
use homeplanet\Serializer\Normalizer\DoctrineEntityNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;

/**
 *
 */
class OverviewController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	/**
	 * Display current user overview
	 * @Route("/overview", name="overview")
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
		
		
		return $this->render( 
			'homeplanet/page/overview.html.twig', 
			[
				'user' => $this->getUser(),
				'gameview' => $this->_createViewMin($oGame, $oLocation),
			]
		);
	}
	
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
