<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/house")
 */
class HouseController extends BaseController {

//_____________________________________________________________________________
//	Action	
	
	/**
	 * @Route("/{id}", name="house_view")
	 */
	public function viewAction( $id, Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oUser = $this->getUser();
		$oGame = $this->getGame();
		$oLocation = $this->_oLocation;
		$oPlayer = $oGame->getPlayer();
		
		$oHouse = $id == '' ? 
			$oPlayer->getHouse() :
			$this->getHouseRepo()->find( $id )
		;
		
		// @var House $oHouse
		if( $oHouse == null ) throw $this->createNotFoundException('No character found');
		
		//_____________________________
		// Render
		
		return $this->render(
			'homeplanet/page/printo.html.twig',
			[
				'title' => 'House',
				'user' => $this->getUser(),
				'gameview' => $this->_createView($oGame, $oLocation),
				'o' => $oPlayer->getHouse(),
			]
		);
	}
	
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
