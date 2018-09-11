<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Player;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\Character;
use homeplanet\Entity\PawnType;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionInput;

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
	
	public function getPawnAr_byPlayer_indexedByLocation( Player $oPlayer ) {
		$a = [];
		foreach( $this->getPawnAr_byPlayer($oPlayer) as $oEntity ) {
			foreach( $oEntity->getLocationAr() as $oLocation ) {
				$sLocation = (string)$oLocation;
				$a[$sLocation] = isset($a[$sLocation])?$a[$sLocation]:[];
				$a[$sLocation][] = $oEntity;
			}
		}
		return $a;
	}
	
	/**
	 * 
	 * @param int $iBot
	 * @param int $iTop
	 * @param int $iLeft
	 * @param int $iRight
	 * @return Pawn[]
	 */
	public function findByArea( $iBot, $iTop, $iLeft, $iRight, $iPlayerId ) {
	
		$oQuery = $this->_em->createQuery('
SELECT pawn, pos
FROM homeplanet\Entity\Pawn pawn
JOIN pawn._aPosition pos
WHERE pos._x BETWEEN :left AND :right
	AND pos._y BETWEEN :bot AND :top
	AND pawn._oPlayer = :player_id
		');
		
		$oQuery->setParameters( array(
			'bot' => $iBot,
			'top' => $iTop,
			'left' => $iLeft,
			'right' => $iRight,
			'player_id' => $iPlayerId,
		))
		;
		return $oQuery->getResult();
	}

	
//_____________________________________________________________________________
//	Factory

	public function createContract(
		Player $oPlayer,
		Character $oCharacter
	) {
		$em = $this->getEntityManager();
		$oPawnTypeContract = $em
			->getRepository(PawnType::class)
			->find(3000/* contract type */)
		; // TODO : identify otherwise
		
		$oPawn = new Pawn( $oPawnTypeContract );
		$oPawn->setPlayer($oPlayer);
		$oPawn->addProduction( $this->_createProd( 
			$oPawn, 
			$oCharacter->getLocation() 
		) );
		
		$oCharacter->setWorkplace( $oPawn );
		$em->persist( $oPawn );
		
		return $oPawn;
	}
	
//_____________________________________________________________________________
//	Sub-routine

	// TODO : move to prod repo ?
	private function _createProd( Pawn $oPawn, Location $oLocation ) {
		
		foreach( $oPawn->getType()->getProdTypeAr() as $oProdType ) {
			$oProd = new Production($oPawn, $oLocation, $oProdType );
			
			foreach( $oProdType->getProdInputTypeAr() as $oProdInputType ) {
				// Case: natural ressource as input -> set prod ratio
				// Assume there is a unique prod input
				$oProd->getProdInputAr()->add(
					new ProductionInput(
						$oProd,
						$oLocation,
						$oProdInputType
					)
				);
				
			}
			
			// TODO : clean up
			// Limit to 1
			return $oProd;
		}
	}

}