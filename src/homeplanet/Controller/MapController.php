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
use homeplanet\Entity\PawnFactory;
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
class MapController extends BaseController {
	

//_____________________________________________________________________________
//	Action
	
	/**
	 * @Route("/map_overview", name="map_overview")
	 */
	public function mainAction( Request $oRequest ) {
		$this->_handleRequest( $oRequest );
		
		$oGame = $this->_oGame;
		$oLocation = $this->_oLocation;
		
		$aGameView = $this->_createView($oGame, $oLocation);
		
		$oCity = $oGame->getCityRepo()->getFull($oLocation);
		
		return $this->render(
			'homeplanet/page/map_overview.html.twig',
			[
				'user' => $this->getUser(),
				'gameview' => $aGameView,
				'city' => $oCity,
			]
		);
	}
	
	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
