<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;

class DeckRepository extends EntityRepository {
	
	
//_____________________________________________________________________________
	
	public function find( $iId ) {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT deck, expression
FROM homeplanet\Entity\Deck deck
JOIN deck._aExpression expression
WHERE deck._iId = :id
		');
		$oQuery->setParameters( [
			'id' => $iId,
		]);
		return $oQuery->getOneOrNullResult();
	}
	
	public function findAllCommun() {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT deck, expression
FROM homeplanet\Entity\Deck deck
JOIN deck._aExpression expression
WHERE deck._iId IN (1)
		');
		return $oQuery->getResult();
	}
	/*
	public function findAllOwnedBy( $iPlayerId ) {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT deck, expression
FROM homeplanet\Entity\Deck deck
JOIN deck._oPopulation expression
WHERE deck._iId = :id
		');
		$oQuery->setParameters( [
			'id' => $iId,
		]);
		return $oQuery->getOneOrNullResult();
	}
	*/

}