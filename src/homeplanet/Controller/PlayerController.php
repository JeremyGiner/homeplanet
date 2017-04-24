<?php
namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use homeplanet\Entity\Player;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 *
 */
class PlayerController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	
	/**
	 * @Route("/player/create", name="player_create")
	 */
	public function playerCreateAction( Request $oRequest ) {

		// Deny access to player
		if( $this->getUser()->getPlayer() !== null )
			return $this->redirect( $this->generateUrl('overview'));
		
		//_______________________________
		// Player Create form
		$oPlayer = new Player($this->getUser(), '');
		$oForm = $this->createFormBuilder($oPlayer)
			->add( 'name', TextType::class, ['label' => 'Player name'] )
			->add('submit', SubmitType::class, ['label' => 'Ok'])
			->getForm();
		$oForm->handleRequest( $oRequest );
		if( $oForm->isSubmitted() && $oForm->isValid() ) {
	
			$oData = $oForm->getData();
			//var_dump($oData);
			$oEntityManager = $this->getDoctrine()->getManager();
			$oEntityManager->persist( $oData );
			$oEntityManager->flush();
			return $this->redirect( $this->generateUrl('overview'));
		}
	
		return $this->render(
				'page/page_form.html.twig',
				[
						'title' => 'Create player',
						'form' => $oForm->createView(),
				]
		);
	}
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
