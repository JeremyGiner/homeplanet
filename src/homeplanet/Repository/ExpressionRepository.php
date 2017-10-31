<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;

class ExpressionRepository extends EntityRepository {
	
	/**
	 * 
	 * @param int $iPlayerId
	 * @return integer[]
	 */
	public function getIdByPlayerOwnership( $iPlayerId ) {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT expression._iId
FROM homeplanet\Entity\Player player
JOIN player._oCharacter character
JOIN character._aExpression expression
WHERE player._iId = :id
		');
		$oQuery->setParameters( [
			'id' => $iPlayerId,
		]);
		return array_map('current', $oQuery->getScalarResult());
	}
	
	/**
	 * 
	 * @param int $iPlayerId
	 * @return integer[]
	 */
	public function getIdByPlayerDeck( $iPlayerId ) {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT expression._iId
FROM homeplanet\Entity\Player player
JOIN player._oCharacter character
JOIN character._aExpression expression
WHERE player._iId = :id
		');
		$oQuery->setParameters( [
			'id' => $iPlayerId,
		]);
		return array_map('current', $oQuery->getScalarResult());
	}
	
	
//_____________________________________________________________________________


	
}