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
use homeplanet\tool\TileValidatorResolver;
use homeplanet\Entity\Conversation;
use homeplanet\Form\ConversationExpressionChoiceForm;
use homeplanet\Form\ConversationExpressionChoice;

/**
 *
 */
class PlanetController extends BaseController {
	
	
//_____________________________________________________________________________
//	Action	
	
	/**
	 * @Route("/play", name="play")
	 */
	public function playAction( Request $oRequest ) {
		
		$this->_handleRequest( $oRequest );
		
		$oEntityManager = $this->getDoctrine()->getManager();
		
		$oUser = $this->getUser();
		
		// Get location
		$oLocation = $this->_oLocation;
		
		// Check game
		$oGame = $this->_oGame;
		
		//_____________________________
		// Delete entity
		
		$oFormEntityDelete = $this->createFormBuilder(null,[])
			->add('entity_id',HiddenType::class,['data' => null ])
			->add('submit',SubmitType::class,['label'=>'Delete'])
			->getForm();
		$oFormEntityDelete->handleRequest( $oRequest );
		if( $oFormEntityDelete->isSubmitted() && $oFormEntityDelete->isValid() ) {
		
			$oData = $oFormEntityDelete->getData();
			var_dump($oData);
		}
		
		//_____________________________
		// Process
		if( $oRequest->get('game_run') != null ) {
			$oGame->process();
		}
		
		//test
		//$oGame->getWorldmap()->loadSector(0, 0);
		
		// Render game
		//$oGameViewFactory = $this->_gameViewFactory_get( $oGame, $oContext );
		
		return $this->render( 
			'page/play.html.twig', 
			[
				'date' => \date('d/m/Y H:i:s'),
				'user' => $this->getUser(),
				'form_entity_delete_ar' => $this->_getFormViewEntityDeleteAr($oGame, $oUser),//$oFormEntityDelete->createView(),
				'gameview' => $this->_createView($oGame, $oLocation),
				'city' => $oGame->getCityRepo()->getFull($oLocation),
				'pawnAr' => $oGame->getPawnRepo()->getPawnAr_byPlayer( $oGame->getPlayer() ),
			]
		);
	}
	
//_____________________________________________________________________________

	

	
//_____________________________________________________________________________

	/**
	 * @Route("/entity_delete", name="entity_delete")
	 */
	public function deleteAction( Request $oRequest ) {
		
		$this->_handleRequest($oRequest);
		
		$oUser = $this->getUser();
		$oGame = $this->getGame();
		
		//
		$oEntManager = $this->getDoctrine()->getEntityManager();
		
		$aForm = $this->_getFormEntityDeleteAr( $oGame, $oUser );
		foreach ( $aForm as $oForm ) {
			
			// Skip unsubmited/invalid form
			$oForm->handleRequest( $oRequest );
			if( !$oForm->isSubmitted() || !$oForm->isValid() )
				continue;
			
			$iEntityId = $oForm->getData()['entity_id'];
			
			// Fast delete
			$oEntityRef = $oEntManager->getReference( Pawn::class, $iEntityId );
			$oEntManager->remove( $oEntityRef );
			
			// Commit
			$oEntManager->flush();
			
			break;
		}
		return $this->redirect( $this->generateUrl('play') );
	}
	
	/**
	 * @Route("/test_conversation", name="test_conversation")
	 */
	public function testConversationAction( Request $oRequest ) {
		
		$this->_handleRequest($oRequest);
		
		/* @var $oConversation Conversation */
		$oConversation = $this->getGame()->getEntityManager()->find(Conversation::class, 1);
		
		
		$oFormExpression = $this->createForm( 
			ConversationExpressionChoiceForm::class, 
			new ConversationExpressionChoice( $oConversation->getCharacter0(), $oConversation->getCharacter0()->getExpressionAr()[1] )
		);
		
		return $this->render( 
			'homeplanet/page/conversation.html.twig', 
			[
				'gameview' => $this->_createView($this->_oGame, $this->_oLocation),
				'conversation' => $oConversation,
				'form' => $oFormExpression->createView(),
			]
		);
	}

//_____________________________________________________________________________

	/**
	 * @Route("/planet_test", name="planet_test")
	 */
	public function testAction( Request $oRequest ) {
		
		$oResponse = new Response();
		$oResponse->headers->set('Content-Type', 'image/png');
		
		// HTTP Caching
		$oResponse->setPublic();
		//$oResponse->setEtag('map'.(0).':'.(0));
		$oResponse->setEtag('map');
		//$oResponse->setLastModified(new \DateTime('2000-02-30'));
		$oResponse->setLastModified(new \DateTime('2017-02-30'));
		
		
		if( $oResponse->isNotModified($oRequest) ) {
			return $oResponse;
		}
		
		// Generate image
		// TODO : move elsewhere
		function _getColor( $gd, &$aColor, $r, $g, $b ) {
			$sKey = $r.':'.$g.':'.$b;
			if( !isset( $aColor[ $sKey ] ) )
				$aColor[ $sKey ] = imagecolorallocate($gd, $r, $g, $b);
		
			return $aColor[ $sKey ];
		}
		
		$oGame = new Game( $this->getUser(), $this->getDoctrine()->getManager(), 0, 0 );
		
		$oMap = $oGame->getWorldmap();
		$oMap->loadSector(0, 0);
		
		$iWidth = 169;
		$iHeight = 169;
		
		$gd = imagecreatetruecolor($iWidth, $iHeight);
		
		$aColor = [];
		for ($x = 0; $x < $iWidth; $x++) {
			for ($y = 0; $y < $iHeight; $y++) {
				$oTile = $oMap->getTile($x, $y);
				$aRGB = $oTile->getColorRGB();
				
				$iColorId = _getColor($gd, $aColor, $aRGB[0], $aRGB[1], $aRGB[2] );
				
				imagesetpixel($gd, $x, $iHeight-1-$y, $iColorId );
			}
		}
		
		
		
		// Set response content
		ob_start();
		
		imagepng($gd);
		
		$stringdata = ob_get_contents(); // read from buffer
		ob_end_clean(); // delete buffer
		
		$oResponse->setContent($stringdata);
		
		return $oResponse;
	}
	
	/**
	 * @Route("/css/ressource_atlas.css", name="ressource_atlas")
	 */
	function cssAction( Request $oRequest ) {
		$oResponse = new Response();
		$oResponse->headers->set('Content-Type', 'text/css');
		return $this->render( 'css/atlas.css.twig', [
			'atlas_label' => 'ress-sprite',
			'atlas_path' => 'http://vignette1.wikia.nocookie.net/thesettlersonline/images/d/d5/ResCSS.png/revision/latest?cb=20140501225055',
			'atlas_res_x' => 12,
			'atlas_res_y' => 12,
		], $oResponse );
	}
	

	
//_____________________________________________________________________________
	
	

	
	
//_____________________________________________________________________________
//	Accessor

	public function getGame() {
		return $this->_oGame;
	}
	
	public function getLocation() {
		return $this->_oLocation;
	}
	
	protected static function getBundleNameFromEntity($entityNamespace, $bundles)
	{
		$dataBaseNamespace = substr($entityNamespace, 0, strpos($entityNamespace, '\\Entity\\'));
		foreach ($bundles as $type => $bundle) {
			$bundleRefClass = new \ReflectionClass($bundle);
			if ($bundleRefClass->getNamespaceName() === $dataBaseNamespace) {
				return $type;
			}
		}
	}
	
//_____________________________________________________________________________
//	Sub-routine
	

	/**
	 * @return FormInterface[] indexed by entity id
	 */
	function _getFormEntityDeleteAr( Game $oGame, User $oUser ) {
		$a = [];
		foreach( $oGame->getPawnRepo()->getPawnAr_byPlayer($oGame->getPlayer()) as $oEntity ) {
			$a[$oEntity->getId()] = $this->_getFormEntityDelete( $oEntity->getId() );
		}
		return $a;
	}
	function _getFormViewEntityDeleteAr( Game $oGame, User $oUser ) {
		$a = $this->_getFormEntityDeleteAr( $oGame, $oUser);
	
		$aFormView = [];
		foreach( $a as $iKey => $o )
			$aFormView[$iKey] = $o->createView();
	
		return $aFormView;
	}
	/**
	 * @param int $i
	 * @return FormInterface
	 */
	function _getFormEntityDelete( $i ) {
		return $this->get('form.factory')->createNamedBuilder(
				'form_entity_delete_'.$i,
				FormType::class,null,[]
		)
		->setAction($this->generateUrl('entity_delete'))
		->add('entity_id',HiddenType::class,['data' => $i ])
		->add('submit',SubmitType::class,['label'=>'Delete'])
		->getForm();
	}
	
}
