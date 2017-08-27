<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;

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
			->useResultCache(true);
		return $oQuery->getResult();
	}
	
//_____________________________________________________________________________

	public function getRandomList( Location $oLocation ) {
		$aCharacter = [];
		
		$aCharacter = $this->findBy([ 
				'locationX' => $oLocation->getX(), 
				'locationY' => $oLocation->getY(),
		], [], rand(1,10) );
		
		foreach ( range(0, 10-count( $aCharacter ) ) as $i ) { if( $i == 0 ) continue;
			$oCharacter = $this->_generateCharater( $oLocation );
			if( $oCharacter === null ) continue;
			$aCharacter[] = $oCharacter;
		}
		
		return $aCharacter;
	}
	
	private function _generateCharater( Location $oLocation ) {
		return null;
	} 

}