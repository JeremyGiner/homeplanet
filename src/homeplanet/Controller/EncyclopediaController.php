<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
