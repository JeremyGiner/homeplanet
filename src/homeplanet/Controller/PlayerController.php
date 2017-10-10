<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use homeplanet\Entity\Player;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use homeplanet\Entity\Character;

/**
 *
 */
class PlayerController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	
	/**
	 * @Route("/player/list", name="player_list")
	 */
	public function listAction( Request $oRequest ) {

		$this->_handleRequest( $oRequest );
		
		$oUser = $this->getUser();
		$oGame = $this->getGame();
		$oLocation = $this->_oLocation;
		$oPlayer = $oGame->getPlayer();
		
		/*
		$oGame->getEntityManager()->createQueryBuilder()
			->from(Player::class, 'player')
		*/
		//_____________________________
		// Render
		
		return $this->render(
				'homeplanet/page/leaderboard.html.twig',
				[
						'title' => 'Player list',
						'user' => $this->getUser(),
						'gameview' => $this->_createView($oGame, $oLocation),
						'playerAr' => $oGame->getEntityManager()->getRepository(Player::class)->findAll(),
				]
		);
	}
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
