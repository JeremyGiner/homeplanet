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
use homeplanet\Entity\Entity;
use homeplanet\Game;
use homeplanet\Entity\EntityFactory;
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

/**
 *
 */
class AssetController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	/**
	 * @Route("/asset", name="asset")
	 */
	public function mainAction( Request $oRequest ) {
		
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
		
		$aEntityByLocation = $this->_oGame->getEntityAr_byUser_indexLocation($oUser);
		
		$aFluxByLocation = [];
		foreach( $aEntityByLocation as $sLocation => $aEntity )
		foreach( $aEntity as $oEntity ) {
			if( !isset($aFluxByLocation[$sLocation]) )
				$aFluxByLocation[$sLocation] = [];
			foreach ( $oEntity->getProductionAr() as $oProd ) {
				$iRessId = $oProd->getType()->getRessource()->getId();
				if( !isset( $aFluxByLocation[$sLocation][$iRessId] ) ) 
					$aFluxByLocation[$sLocation][$iRessId] = 0;
				
				$aFluxByLocation[$sLocation][$iRessId] += $oProd->getQuantity();
				
				foreach( $oProd->getProdInputAr() as $oProdInput ) {
					$iRessId = $oProdInput->getType()->getRessource()->getId();
					if( !isset( $aFluxByLocation[$sLocation][$iRessId] ) )
						$aFluxByLocation[$sLocation][$iRessId] = 0;
					
					$aFluxByLocation[$sLocation][$iRessId] -= $oProdInput->getQuantity();
				}
			}
		}
		
		return $this->render( 
			'homeplanet/page/asset.html.twig', 
			[
				'user' => $this->getUser(),
				'gameview' => $this->_createView($oGame, $oLocation),
				'test' => $aEntityByLocation,
				'aFluxByLocation' => $aFluxByLocation,
			]
		);
	}
	
	
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Sub-routine
	
	
}
