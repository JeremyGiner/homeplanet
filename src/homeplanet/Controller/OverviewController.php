<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
	
	/**
	 * Display current user overview
	 * @Route("/calendar", name="calendar")
	 */
	public function calendarAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		//_____________________________
		// Render
		
		return $this->render(
			'homeplanet/page/calendar.html.twig',
			[
				'user' => $this->getUser(),
				'gameview' => $this->_createViewMin(
					$this->getGame(), 
					$this->getLocation()
				)
			]
		);
	}
	
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
