<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
use homeplanet\Entity\MerchantFactory;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\attribute\ProductionType;
use Doctrine\ORM\EntityRepository;
use homeplanet\tool\TileValidatorResolver;

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
	
	
	/**
	 * @Route("/ajax/map_z0", name="ajax_map_z0")
	 */
	function mapAction( Request $oRequest ) {
		$this->_handleRequest($oRequest);
	
		$oLocation = $this->getLocation();
		
		$oValidator = null;
		if( $oRequest->query->has('validator') != null )
		$oValidator = (new TileValidatorResolver())->resolve(
				$oRequest->query->get('validator'),
				$oRequest->query->get('validator_param'),
				$this->_oGame->getWorldmap()
		);
	
		//var_dump($oValidator);
		//exit();
	
		return $this->render(
				'homeplanet/element/map_zoom0.html.twig',
				[
					'map_mod' => true,
					'validator' => $oValidator,
				]+$this->getGame()->getWorldmapView($oLocation)
		);
	}
	
	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
