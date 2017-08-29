<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;

class ExpressionRepository extends EntityRepository {
	
	
	public function getIdByPlayerOwnership( $iPlayerId ) {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT expression._iId
FROM homeplanet\Entity\Player player INDEX BY player._iId
JOIN player._oCharacter character
JOIN character._aKnowledge knowledge WITH knowledge._sType = \'expression\'
JOIN homeplanet\Entity\Expression expression WITH expression._iId = knowledge._iReference
WHERE player._iId = :id
		');
		$oQuery->setParameters( [
			'id' => $iPlayerId,
		]);
		return array_map('current', $oQuery->getScalarResult());
	}
	public function getDeckByPlayer( $iPlayerId ) {
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
		return $oQuery->getResult();
	}
	
	
//_____________________________________________________________________________


	
}