<?php
namespace homeplanet;

use homeplanet\entity\Map;
use homeplanet\Entity\attribute\Location;
use homeplanet\entity\City;
use AppBundle\Entity\User;
use homeplanet\event\Event;
use homeplanet\entity\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;
use homeplanet\entity\Worldmap;
use homeplanet\entity\EntityType;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Overcrowd;
use homeplanet\Entity\attribute\Production;

class Game {
	/**
	 * @var User
	 */
	protected $_oUser;
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
	protected $_aEntityByLoc;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( User $oContextUser, EntityManager $oEntityManager, $iCenterX, $iCenterY ) {
		$this->_oUser = $oContextUser;
		$this->_oEntityManager = $oEntityManager;
		
		// Preload
		//$this->_oEntityManager->getRepository('homeplanet\entity\EntityType')->findAll();
		$this->_oEntityManager->getRepository('homeplanet\Entity\Ressource')->findAll();
		
		$this->_oGameState = $this->_oEntityManager->getRepository('homeplanet\Entity\GameState')->find(1);
		
		$this->_oWorldmap = new Worldmap(0, 0); 
		
		$this->_aEntityByLoc = [];
		$a = $this->getEntityAr_byArea( $iCenterY-6, $iCenterY+6, $iCenterX-6, $iCenterX+6 );
		foreach( $a as $oEntity )
			foreach( $oEntity->getLocationAr() as $oLocation )
				$this->_aEntityByLoc[ (string)$oLocation ][ $oEntity->getId() ] = $oEntity;
		
		$oQuery = $this->_oEntityManager->createQuery('
SELECT entitytype,prodtype
FROM homeplanet\entity\EntityType entitytype
JOIN entitytype._aProdType prodtype
		');
		$oQuery->getResult();
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getEntity( $iEntityId ) {
		return $this->_oEntityManager->getRepository('homeplanet\entity\Entity')->find($iEntityId);
	}
	
	public function getEntityManager() {
		return $this->_oEntityManager;
	}
	
	public function getWorldmap() {
		return $this->_oWorldmap;
	}
	
	public function getCity_byLocation( Location $oLoc ) {
		$a = $this->getEntityAr_byLocation( $oLoc );
		foreach( $a as $o ) {
			if ( $o->getType()->getId() == 1 ) return $o;
		}
		return null;
	}
	
	public function getContextPlayer() {
		return $this->getPlayer( $this->_oUser->getId() );
	}
	
	public function getUser( $iId ) {
		return $this->_oEntityManager->getRepository('AppBundle\Entity\User')->find($iId);
	}
	
	public function getPlayer( $iUserId ) {
		return $this->_oEntityManager->getRepository('homeplanet\entity\Player')->find($iUserId);
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
	public function getEntityType( $iId ) {
		return $this->_oEntityManager->getRepository(EntityType::class)->find($iId);
	}
	
	public function getEntityTypeAr() {
		return $this->_oEntityManager->getRepository('homeplanet\entity\EntityType')->findAll();
	}
	
	public function getProdType( $iId ) {
		return $this->_oEntityManager->getRepository('homeplanet\Entity\attribute\ProductionType')->find($iId);
	}
	
	public function getProdInputType( $iId ) {
		return $this->_oEntityManager->getRepository('homeplanet\Entity\attribute\ProductionInputType')->find($iId);
	}
	/**
	 * Deprecated 
	 * @return null
	 */
	public function getLocation( $x, $y ) {
		return null;
	}
	
	/**
	 * @param Location $oLoc
	 * @return Entity[]
	 */
	public function getEntityAr_byLocation( Location $oLoc ) {
		/*$oQuery = $this->_oEntityManager->createQuery('
SELECT entity
FROM homeplanet\entity\Entity entity
JOIN entity._aPosition pos
WHERE pos._x = :pos_x
	AND pos._y = :pos_y
		');
		$oQuery->setParameters( array(
				'pos_x' => $oLoc->getX(),
				'pos_y' => $oLoc->getY(),
		));*/
		$sLoc = (string)$oLoc;
		return isset($this->_aEntityByLoc[ $sLoc ]) ?
			$this->_aEntityByLoc[ $sLoc ]:
			[];
	}
	
	/**
	 * @param Location $oLoc
	 * @return Entity[]
	 */
	private function getEntityAr_byArea( $iBot, $iTop, $iLeft, $iRight ) {
		
		$oQuery = $this->_oEntityManager->createQuery('
SELECT entity, pop, pos
FROM homeplanet\entity\Entity entity
JOIN entity._aPosition pos
LEFT JOIN entity._oPopulation pop
WHERE pos._x BETWEEN :left AND :right
	AND pos._y BETWEEN :bot AND :top
		');
		$oQuery->setParameters( array(
				'bot' => $iBot,
				'top' => $iTop,
				'left' => $iLeft,
				'right' => $iRight,
		))
		->useQueryCache(true)
		->useResultCache(true)
		;
		return $oQuery->getResult();
	}
	
	/**
	 * @param User $oUser
	 * @return Entity[]
	 */
	public function getEntityAr_byUser( User $oUser ) {
		$oQuery = $this->_oEntityManager->createQuery('
SELECT entity
FROM homeplanet\entity\Entity entity
WHERE entity._oUser = :player
		');
		$oQuery->setParameters( array(
				'player' => $oUser,
		));
		return $oQuery->getResult();
	}
	
	/**
	 * @param int $x
	 * @param int $y
	 * @return Overcrowd[]
	 */
	public function getOvercrowdAr( $x, $y ) {
		return $this->_oEntityManager->getRepository(Overcrowd::class)
			->findBy([
					'_iLocationX' => $x,
					'_iLocationY' => $y,
			]);
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
	
	public function getEntityAr_byUser_indexLocation( User $oUser ) {
		$a = [];
		foreach( $this->getEntityAr_byUser($oUser) as $oEntity ) {
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

	public function addEntity( Entity $oEntity, array $aAddOn = [] ) {
		
		foreach( $oEntity->getProductionAr() as $o ) {
			
			// Prod with natural ress
			$x = $o->getLocation()->getX();
			$y = $o->getLocation()->getY();
			
			// Get ress
			$aInput = $o->getType()->getProdInputTypeAr();
			$oRess = $aInput[0]->getRessource();
			
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
			
			// Update prod ratio
			if(
				$oRess->isNatural() &&
				($iRessNat - $iOvercrowd) > 0
			) {
				$o->setRatio(1.0);
			}
			
		}
		$this->_oEntityManager->persist( $oEntity );
		$this->_oEntityManager->flush();
	}
	
	public function removeEntity( Entity $oEntity ) {
		$this->_oEntityManager->remove( $oEntity );
		$this->_oEntityManager->flush();
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
	
}
