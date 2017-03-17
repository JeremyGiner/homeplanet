<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;

class OvercrowdRepository extends EntityRepository {
	
	
//_____________________________________________________________________________

	
	/**
	 * @param int $ress_id
	 * @param int $x
	 * @param int $y
	 * @return Overcrowd[]
	 */
	public function get( $ress_id, $x, $y ) {
		
		
		return $this->findOneBy([
			'_iLocationX' => $x,
			'_iLocationY' => $y,
			'_iRessourceId' => $ress_id,
		]);
	}
	/**
	 * @param int $x
	 * @param int $y
	 * @return Overcrowd[]
	 */
	public function findByCoordonate( $x, $y ) {
		
		return $this->createQueryBuilder('overcrowd', 'overcrowd._iRessourceId')
			->where('overcrowd._iLocationX = :x')
			->andWhere('overcrowd._iLocationY = :y')
			->setParameter('x', $x)
			->setParameter('y', $y)
			->getQuery()->getResult();
	}
	

}