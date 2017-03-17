<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Player;

class PawnRepository extends EntityRepository {
	
	
//_____________________________________________________________________________
	
	public function getPawnAr_byPlayer( Player $oPlayer ) {
		$oQuery = $this->_em->createQuery('
SELECT entity
FROM homeplanet\Entity\Pawn entity
WHERE entity._oPlayer = :player
		');
		$oQuery->setParameters( array(
				'player' => $oPlayer,
		));
		return $oQuery->getResult();
	}
	
	/**
	 * 
	 * @param int $iBot
	 * @param int $iTop
	 * @param int $iLeft
	 * @param int $iRight
	 * @return Pawn[]
	 */
	public function getPawnAr_byArea( $iBot, $iTop, $iLeft, $iRight ) {
	
		$oQuery = $this->_em->createQuery('
SELECT pawn, pos
FROM homeplanet\Entity\Pawn pawn
JOIN pawn._aPosition pos
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
	

}