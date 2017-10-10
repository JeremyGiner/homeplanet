<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;
use homeplanet\Entity\Character;

class CharacterRepository extends EntityRepository {
	
	
	public function getAcquaintance( $iCharacterId ) {
		$oQuery = $this->getEntityManager()->createQuery('
SELECT acquaintance
FROM homeplanet\Entity\Character character
JOIN character._aKnowledge knowledge WITH knowledge._sType = \'acquaintance\'
LEFT JOIN homeplanet\Entity\Character acquaintance WITH acquaintance._iId = knowledge._iReference
WHERE character._iId = :id 
		');
		$oQuery->setParameters( [
			'id' => $iCharacterId,
		])
			->useQueryCache(true)
			->useResultCache(true)
		;
		return $oQuery->getResult();
	}
	
//_____________________________________________________________________________

	public function getRandom( Location $oLocation = null, $excludeId ) {
		$aCharacter = [];
		
		$oCharacter = $this->getEntityManager()->createQuery('
SELECT character
FROM homeplanet\Entity\Character character
LEFT JOIN homeplanet\Entity\Character character_main 
	WITH character_main._iId = :id 
LEFT JOIN character_main._aAcquaintance acquaintance WITH acquaintance._iId = character._iId
WHERE character._iId != :id 
AND acquaintance._iId IS NULL
		')
//AND character.locationX = :locationX
//AND character.locationY = :locationY
			->setParameters( [
				'id' => $excludeId,
				//'locationX' => $oLocation->getX(), 
				//'locationY' => $oLocation->getY(),
			])
			->setMaxResults(1)
			->getOneOrNullResult()
		;
		if( $oCharacter !== null ) 
			return $oCharacter;
		
		// Generate random char
		$oCharacter = Character::generate( $this->getEntityManager(), $oLocation, 'city' );
		
		return $oCharacter;
	}
	
	private function _generateCharater( Location $oLocation ) {
		return null;
	} 

}