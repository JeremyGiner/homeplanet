<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;
use homeplanet\Entity\Overcrowd;

class OvercrowdRepository extends EntityRepository {
	
	
//_____________________________________________________________________________

	
	/**
	 * @param int $ress_id
	 * @param int $x
	 * @param int $y
	 * @return Overcrowd[]
	 */
	public function get( $ress_id, $x, $y ) {
		
		return $this->find([
			'_iLocationX' => $x,
			'_iLocationY' => $y,
			'_iRessourceId' => $ress_id,
		]);
		/*
		return $this->findOneBy([
			'_iLocationX' => $x,
			'_iLocationY' => $y,
			'_iRessourceId' => $ress_id,
		]);
		*/
	}
	/**
	 * @param int $x
	 * @param int $y
	 * @return Overcrowd[]
	 */
	public function findByCoordonate( $x, $y ) {
		return $this->findByCoordonateAr([[$x,$y]]);
		/*
		return $this->createQueryBuilder('overcrowd', 'overcrowd._iRessourceId')
			->where('overcrowd._iLocationX = :x')
			->andWhere('overcrowd._iLocationY = :y')
			->setParameter('x', $x)
			->setParameter('y', $y)
			->getQuery()->getResult();
		*/
	}
	
	/**
	 * 
	 * @param int[] $a format [[x,y],...]example : [[1,4],[3,-5]]
	 */
	public function findByCoordonateAr( $aCoordonate ) {
		$q = $this->createQueryBuilder('overcrownd')
			->select('overcrowd')
			->from(Overcrowd::class,'overcrowd')
		;
		$a = [];
		$i = 0;
		foreach ( $aCoordonate as $coordonate ) {
			$q->orWhere('overcrowd._iLocationX = ?'.$i++.' AND overcrowd._iLocationY = ?'.$i++);
			$a[] = $coordonate[0];
			$a[] = $coordonate[1];
		}
		$q->setParameters($a);
		return $q->getQuery()->getResult();
	}
	

}