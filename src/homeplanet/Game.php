<?php
namespace homeplanet;

use AppBundle\Entity\User;
use homeplanet\Entity\attribute\Location;
use homeplanet\entity\City;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Worldmap;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Overcrowd;
use homeplanet\Entity\attribute\Production;
use homeplanet\Repository\CityRepository;
use homeplanet\Repository\OvercrowdRepository;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\Player;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use homeplanet\Entity\PawnType;
use homeplanet\Entity\attribute\ProductionInputType;
use homeplanet\Repository\PawnRepository;
use homeplanet\Repository\ProductionRepository;

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
	
	/**
	 * Indexed by location (serialized) then by id
	 * @var Entity[][]
	 */
	protected $_aPawnByLoc;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( User $oContextUser, EntityManager $oEntityManager, $iCenterX, $iCenterY ) {
		$this->_oUser = $oContextUser;
		$this->_oEntityManager = $oEntityManager;
		
		$this->_oPlayer = $this->_oEntityManager->getRepository(Player::class)
			->findOneBy(['_oUser' => $this->_oUser->getId()]);
		
		// Preload
		$this->_oEntityManager->getRepository(Ressource::class)->findAll();
		
		$this->_oGameState = null;
		//$this->_oGameState = $this->_oEntityManager->getRepository('homeplanet\Entity\GameState')->find(1);
		
		$this->_oWorldmap = new Worldmap( $this ); 
		
		$this->_aPawnByLoc = [];
		$a = $this->getPawnRepo()->getPawnAr_byArea( $iCenterY-6, $iCenterY+6, $iCenterX-6, $iCenterX+6 );
		foreach( $a as $oEntity )
			foreach( $oEntity->getLocationAr() as $oLocation )
				$this->_aPawnByLoc[ (string)$oLocation ][ $oEntity->getId() ] = $oEntity;
		
		$oQuery = $this->_oEntityManager->createQuery('
SELECT pawntype,prodtype
FROM homeplanet\Entity\PawnType pawntype
JOIN pawntype._aProdType prodtype
		');
		$oQuery->getResult();
	}
	
//_____________________________________________________________________________
//	Accessor
	
	/**
	 * @return CityRepository
	 */
	public function getCityRepo() {
		return $this->_oEntityManager->getRepository(City::class);
	}
	
	/**
	 * @return PawnRepository
	 */
	public function getPawnRepo() {
		return $this->_oEntityManager->getRepository(Pawn::class);
	}
	
	/**
	 * @return ProductionRepository
	 */
	public function getProductionRepo() {
		return $this->_oEntityManager->getRepository(Production::class);
	}
	
	public function getEntityManager() {
		return $this->_oEntityManager;
	}
	
	public function getWorldmap() {
		return $this->_oWorldmap;
	}
	
	public function getCity_byLocation( Location $oLoc ) {
		$a = $this->getPawnAr_byLocation( $oLoc );
		foreach( $a as $o ) {
			if ( $o->getType()->getId() == 1 ) return $o;
		}
		return null;
	}
	
	public function getContextPlayer() {
		return $this->getPlayer( $this->_oUser->getId() );
	}
	
	public function getUser( $iId ) {
		return $this->_oEntityManager->getRepository(User::class)->find($iId);
	}
	
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
	
	
	
	/**
	 * @return OvercrowdRepository
	 */
	public function getOvercrowdRepo() {
		return $this->_oEntityManager->getRepository(Overcrowd::class);
	}
	
	/**
	 * @param int $ress_id
	 * @param int $x
	 * @param int $y
	 * @return Overcrowd[]
	 */
	public function getOvercrowd( $ress_id, $x, $y ) {
		return $this->_oEntityManager->getRepository(Overcrowd::class)
			->findOneBy([
					'_iLocationX' => $x,
					'_iLocationY' => $y,
					'_iRessourceId' => $ress_id,
			]);
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
		
		foreach( $oPawn->getProductionAr() as $oProd ) {
			
			$this->updateProductionRatio($oProd);
			
		}
		$this->_oEntityManager->persist( $oPawn );
		$this->_oEntityManager->flush();
	}
	
	public function removeEntity( Pawn $oPawn ) {
		$this->_oEntityManager->remove( $oPawn );
		$this->_oEntityManager->flush();
	}
	public function updateProductionRatio( Production $oProduction ) {
		
		$oProduction->setGrade( $oProduction->getPawn()->getGrade() );
		
		if( $oProduction->isHarvester() )
			$this->_updateHarvester( $oProduction );
			
	}
	
//_____________________________________________________________________________
//	Process
	
	public function process() {
		
		/*
		$i = (new \DateTime())->getTimestamp() - $this->_oGameState->getTimeOrigin()->getTimestamp();
		$iTurn = floor(( $i / 60 ) / 10);
		var_dump($iTurn);
		return;*/
		
		// Update prod
		// Update flux
		// Update cities pop growth
		$oQuery = $this->_oEntityManager
			->getConnection()
			->executeUpdate('CALL turn()');
		
		$this->_oEntityManager->flush();
	}
	
//_____________________________________________________________________________
//	Sub-routine

	function _updateHarvester( Production $oProduction ) {
		// Get first prod input
		$aInput = $oProduction->getProdInputAr();
		
		// Case : no input for this prod
		if( !isset($aInput[0]) )
			return;
		
		// Get prod input
		$oInput = $aInput[0];
		
		// Get resource
		$oRess = $oInput->getType()->getRessource();
		
		// Filter not nautral
		if( !$oRess->isNatural() )
			return;
		
		// Prod with natural ress
		$x = $oProduction->getLocation()->getX();
		$y = $oProduction->getLocation()->getY();
			
		// Get natural deposit
		$oTile = $this->getWorldmap()->getTile(
				$x,
				$y
		);
		$aRessNat = $oTile->getRessNatQuantityAr();
		$iRessNat = isset( $aRessNat[ $oRess->getId() ] )?
		$aRessNat[ $oRess->getId() ]:0;
		
		// Get overcrowd
		$oOvercrowd = $this->getOvercrowd($oRess->getId(), $x, $y);
		$iOvercrowd = $oOvercrowd != null ? $oOvercrowd->getQuantity() : 0;
		
		// Get current allocated ressource
		$old = $oInput->getQuantity();
			
		// Update prod ratio
		$iCurrentAvailable = $iRessNat - $iOvercrowd;
		if( $iCurrentAvailable > 0 ) {
			
			// Let setRatio cap top the ratio wti hthe grade
			$oProduction->setRatio( $iCurrentAvailable + $old );
		}
	}
}