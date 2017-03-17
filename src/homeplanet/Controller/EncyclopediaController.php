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
use homeplanet\Entity\attribute\homeplanet\Entity\attribute;
use homeplanet\Entity\TradeRouteFactory;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Player;
use homeplanet\Form\BuildingBuy;
use homeplanet\Form\BuildingBuyForm;
use homeplanet\Form\TradeRouteCreationForm;
use homeplanet\Form\MerchantCreationForm;
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
use homeplanet\Entity\ResCategory;

/**
 *
 */
class EncyclopediaController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	/**
	 * @Route("/ressource", name="ressource")
	 */
	public function ressourceAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oEntityManager = $this->getDoctrine()->getManager();
		
		$oUser = $this->getUser();
		
		// Get location
		$oLocation = $this->_oLocation;
		
		// Check game
		$oGame = $this->_oGame;
		
		//_____________________________
		// Render game
		//$oGameViewFactory = $this->_gameViewFactory_get( $oGame, $oContext );
		
		return $this->render( 
			'homeplanet/page/ressource.html.twig', 
			[
				'user' => $this->getUser(),
				'aRessource' => $this->_oGame->getRessourceAr(),
				'aRessCat' => $this->_oGame
					->getEntityManager()
					->getRepository(ResCategory::class)
					->findAll(),
				//'gameview' => $this->_createView($oGame, $oLocation),
			]
		);
	}
	
	
	
//_____________________________________________________________________________
//	Accessor

	
	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
