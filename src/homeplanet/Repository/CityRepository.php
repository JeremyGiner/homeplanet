<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;

class CityRepository extends EntityRepository {
	
	
//_____________________________________________________________________________

	
	public function findByLocation( Location $o ) {
		return $this->findByCoord($o->getX(), $o->getY());
	}
	
	public function findByCoord( $x, $y ) {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT city
FROM homeplanet\Entity\City city
WHERE city._x = :x
	AND city._y = :y
		');
		$oQuery->setParameters( [
			'x' => $x,
			'y' => $y,
		])
			->useQueryCache(true)
			->useResultCache(true);
		return $oQuery->getResult();
	}
	
	/**
	 * 
	 * @param unknown $iBot
	 * @param unknown $iTop
	 * @param unknown $iLeft
	 * @param unknown $iRight
	 * @return City[]
	 */
	public function findByArea( $iBot, $iTop, $iLeft, $iRight ) {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT city
FROM homeplanet\Entity\City city
WHERE city._x BETWEEN :left AND :right
	AND city._y BETWEEN :bot AND :top
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
	

}