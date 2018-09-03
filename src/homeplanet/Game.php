<?php
namespace homeplanet;

use AppBundle\Entity\User;
use homeplanet\Entity\attribute\Location;
use homeplanet\entity\City;
use homeplanet\Entity\Character;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\Player;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use homeplanet\Entity\PawnType;
use homeplanet\Entity\attribute\ProductionInputType;
use homeplanet\Repository\PawnRepository;
use homeplanet\Repository\ProductionRepository;
use homeplanet\Entity\GameState;
use homeplanet\Entity\Expression;
use homeplanet\Repository\ExpressionRepository;
use homeplanet\Entity\Deck;
use homeplanet\Repository\DeckRepository;
use AppBundle\Tool\ArrayTool;
use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\House;

class Game {
	/**
	 * @var User
	 */
	protected $_oUser;
	
	/**
	 * @var Player
	 */
	protected $_oPlayer;
	
	/**
	 * Doctrine entity manager
	 * @var EntityManager 
	 */
	protected $_oEntityManager;
	/**
	 * @var GameState
	 */
	protected $_oGameState;
	/**
	 * @var Worldmap
	 */
	protected $_oWorldmap;
	
	static private $_oInstance = null;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( User $oContextUser, EntityManager $oEntityManager, $iCenterX, $iCenterY ) {
		
		$this->_oUser = $oContextUser;
		$this->_oEntityManager = $oEntityManager;
		
		
		//$this->_oPlayer = $this->_oEntityManager->getRepository(Player::class)
		//	->findOneBy(['_oUser' => $this->_oUser->getId()]);
		$this->_oPlayer = $this->_oUser->getPlayer();
		
		// Preload
		$this->_oEntityManager->getRepository(Ressource::class)->findAll();
		
		$this->_oGameState = null;
		//$this->_oGameState = $this->_oEntityManager->getRepository('homeplanet\Entity\GameState')->find(1);
		
		$this->_oWorldmap = new Worldmap( $this ); 
		
		$oQuery = $this->_oEntityManager->createQuery('
SELECT pawntype,prodtype
FROM homeplanet\Entity\PawnType pawntype
JOIN pawntype._aProdType prodtype
		');
		$oQuery->getResult();
		
		self::$_oInstance =$this;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	static public function getInstance() {
		return self::$_oInstance;
	}

	/**
	 * 
	 * @return GameState
	 */
	public function getState() {
		return $this->_oEntityManager->find( GameState::class, 1 );
	}
	
	public function getEntityManager() {
		return $this->_oEntityManager;
	}
	
	public function getWorldmap() {
		return $this->_oWorldmap;
	}
	
	public function getWorldmapView( Location $oLocation ) {
		
		$aPawn = $this->getEntityManager()->getRepository(Pawn::class)->findByArea(
			$oLocation->getRegionY()*13,     //Bottom
			($oLocation->getRegionY()+1)*13, //Top
			$oLocation->getRegionX()*13,     //Left
			($oLocation->getRegionX()+1)*13, //Right
			$this->getPlayer()->getId()
		);
		
		// Index by location
		//$aPawn = ArrayTool::STindexBy($aPawn, 'location');
		$aTmp = [];
		foreach( $aPawn as $oPawn ) 
		foreach( $oPawn->getLocationAr() as $oPawnLocation ) {
			$sLocation = (string)$oPawnLocation;
			if( ! isset( $aTmp[ $sLocation ] ) ) 
				$aTmp[ $sLocation ] = [];
			
			$aTmp[ $sLocation ][] = $oPawn;
		}
		$aPawn = $aTmp;
		
		// Get cities
		$aCity = $this
			->getEntityManager()
			->getRepository(City::class)
			->findByArea(
				$oLocation->getRegionY()*13,     //Bottom
				($oLocation->getRegionY()+1)*13, //Top
				$oLocation->getRegionX()*13,     //Left
				($oLocation->getRegionX()+1)*13  //Right
			)
		;
		
		// Index by location
		//TODO : make indexBy compatible with stringable object
		//$aCity = ArrayTool::STindexBy($aCity, 'location');	
		$a = [];
		foreach ( $aCity as $oCity ) {
			$a[ (string)$oCity->getLocation() ] = $oCity;
		}
		$aCity = $a;
		
		return [
			'location' => $oLocation,
			'worldmap' => $this->getWorldmap(),
			'pawnAr' => $aPawn,
			'cityAr' => $aCity,
		];
	}
	
	public function getContextPlayer() {
		return $this->getPlayer( $this->_oUser->getId() );
	}
	
	public function getUser( $iId ) {
		return $this->_oEntityManager->getRepository(User::class)->find($iId);
	}
	/**
	 * @param integer $iUserId
	 * @return \homeplanet\Entity\Player
	 */
	public function getPlayer( $iUserId = null ) {
		if( $iUserId === null )
			return $this->_oPlayer;
		return $this->_oEntityManager->getRepository(Player::class)->find($iUserId);
	}
	
	public function getRessource( $iId ) {
		return $this->_oEntityManager->getRepository(Ressource::class)->find($iId);
	}
	/**
	 * @return Ressource[]
	 */
	public function getRessourceAr() {
		return $this->_oEntityManager->getRepository(Ressource::class)->findAll();
	}
	
	/**
	 * @param int $iId
	 * @return EntityType
	 */
	public function getPawnType( $iId ) {
		return $this->_oEntityManager->getRepository(PawnType::class)->find($iId);
	}
	
	public function getPawnTypeAr() {
		return $this->_oEntityManager->getRepository(PawnType::class)->findAll();
	}
	
	public function getProdType( $iId ) {
		return $this->_oEntityManager->getRepository(ProductionType::class)->find($iId);
	}
	
	public function getProdInputType( $iId ) {
		return $this->_oEntityManager->getRepository(ProductionInputType::class)->find($iId);
	}
	
	/**
	 * @param Location $oLoc
	 * @return Entity[]
	 */
	public function getPawnAr_byLocation( Location $oLoc ) {
		/*$oQuery = $this->_oEntityManager->createQuery('
SELECT entity
FROM homeplanet\Entity\Pawn entity
JOIN entity._aPosition pos
WHERE pos._x = :pos_x
	AND pos._y = :pos_y
		');
		$oQuery->setParameters( array(
				'pos_x' => $oLoc->getX(),
				'pos_y' => $oLoc->getY(),
		));*/
		$sLoc = (string)$oLoc;
		return isset($this->_aPawnByLoc[ $sLoc ]) ?
			$this->_aPawnByLoc[ $sLoc ]:
			[];
	}
	
	public function getPawnAr_byPlayer_indexLocation( Player $oPlayer ) {
		$a = [];
		foreach( $this->getPawnRepo()->getPawnAr_byPlayer($oPlayer) as $oEntity ) {
			foreach( $oEntity->getLocationAr() as $oLocation ) {
				$sLocation = (string)$oLocation;
				$a[$sLocation] = isset($a[$sLocation])?$a[$sLocation]:[];
				$a[$sLocation][] = $oEntity;
			}
		}
		return $a;
	}
	
//_____________________________________________________________________________
//	Modifier

	public function addPawn( Pawn $oPawn, array $aAddOn = [] ) {
		
		
	}
	
	public function removeEntity( Pawn $oPawn ) {
		$this->_oEntityManager->remove( $oPawn );
		$this->_oEntityManager->flush();
	}
	public function updateProductionRatio( Production $oProduction ) {
		
		$oProduction->setGrade( $oProduction->getPawn()->getGrade() );
			
	}
	
//_____________________________________________________________________________
//	Sub-routine

}