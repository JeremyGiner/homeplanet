<?php

namespace homeplanet\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use homeplanet\Entity\attribute\Location;
use homeplanet\Game;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use homeplanet\Entity\Player;

class BaseController extends Controller {
	
	/**
	 * @var Location
	 */
	protected $_oLocation = null;
	/**
	 * @var Game
	 */
	protected $_oGame = null;

//_____________________________________________________________________________
//	Accessor
	
	public function getGame() {
		return $this->_oGame;
	}
	
	/**
	 * @return Player
	 */
	public function getPlayer() {
		return $this->getUser()->getPlayer();
	}
	
	public function getLocation() {
		return $this->_oLocation;
	}
	

//_____________________________________________________________________________
//	Sub-routine

	protected function _handleRequest( Request $oRequest = null ) {
	
		$oSession = $oRequest->getSession();
	
		// Get location (by order of priority : GET, session, const value)
		$this->_oLocation = null;
		if( $this->_oLocation == null && $oRequest != null && $oRequest->get('location') != null )
			$this->_oLocation = Location::getFromString( $oRequest->get('location') );
		if( $this->_oLocation == null && $oSession->has('location') )
			$this->_oLocation = Location::getFromString( $oSession->get('location') );
		if( $this->_oLocation == null )
			$this->_oLocation = new Location(7,7);
			
		// Update session
		$oSession->set('location', (string)$this->_oLocation );
	
		// Retrieve game
		$this->_oGame = new Game(
				$this->getUser(),
				$this->getDoctrine()->getManager(),
				$this->_oLocation->getX(),
				$this->_oLocation->getY()
		);
		
	}
	
	/**
	 * 
	 * @param string $name
	 * @param mixed $type
	 * @param mixed $data
	 * @param array $options
	 * @param FormBuilderInterface $parent
	 * @return FormBuilderInterface
	 */
	public function createNamedBuilder(
		$name, 
		$type = null, 
		$data = null, 
		array $options = array(), 
		FormBuilderInterface $parent = null
	) {
		if( $type == 'form' || $type == null )
			$type = FormType::class;
		return $this->get('form.factory')->createNamedBuilder(
				$name,
				$type,
				$data,
				$options,
				$parent
		);
	}
	
	// TODO : create class
	function _createView( Game $oGame, Location $oLocation ) {
		
		// Get Overcrowd indexed by ressrouce id
		$aOvercrowd = $oGame->getOvercrowdRepo()->findByCoordonate(
			$oLocation->getX(),
			$oLocation->getY()
		);
		
		// Get cities
		$aCity = $oGame->getCityRepo()->findByArea(
			$oLocation->getRegionY()*13, //Bottom
			($oLocation->getRegionY()+1)*13, //Top
			$oLocation->getRegionX()*13, //Left
			($oLocation->getRegionX()+1)*13	//Right
		);
		if( count( $aCity ) > 0 )
		$aCity[1]->getSovereign()->getColorPrimary();
		
		// Index by location
		$a = [];
		foreach ( $aCity as $oCity ) {
			$a[ (string)$oCity->getLocation() ] = $oCity;
		}
		$aCity = $a;
		
		$oGameSate = $oGame->getState();
			
		return array_merge( [
				'player' => $oGame->getPlayer(),
				//'location' => $oLocation,
				'zoom' => 0,
				'game' => $oGame,
				//'worldmap' => $oGame->getWorldmap(),
				//'pawnAr' => $oGame->getPawnRepo(),
				'overcrowd' => $aOvercrowd,
				'cityAr' => $aCity,
				'turn' => $oGameSate->getTurn(),
				'year' => $oGameSate->getYear(),
				'month' => $oGameSate->getMonth(),
		], $oGame->getWorldmapView( $oLocation ) );
	}
	
	// TODO : create class
	function _createViewMin( Game $oGame, Location $oLocation ) {
		
		$oGameSate = $oGame->getState();
		
		return [
				'player' => $oGame->getPlayer(),
				'location' => $oLocation,
				'turn' => $oGameSate->getTurn(),
				'year' => $oGameSate->getYear(),
				'month' => $oGameSate->getMonth(),
		];
	}
}
