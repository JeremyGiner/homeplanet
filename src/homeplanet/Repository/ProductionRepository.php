<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Player;
use homeplanet\Entity\attribute\Production;

class ProductionRepository extends EntityRepository {
	
//_____________________________________________________________________________
	
	public function updateProduction() {

		$this->_em
			->getConnection()
			->prepare('CALL prod_update_single()')
			->execute([])
		;
		
		return $this;
	}
	/**
	 * 
	 * @param Production $oProd
	 * @return Production[]
	 */
	public function getSupplied( Production $oProd ) {
		
		/*
		$oQueryBuilder = $this->getEntityManager()->createQueryBuilder()
			->select('prod')
			->from(Porduction::class, 'prod')
			->leftJoin(Production::class, 'supplier')
		;
		*/
		
		$oQuery = $this->getEntityManager()->createQuery('
SELECT prod
FROM 
	homeplanet\Entity\attribute\Production prod
	
JOIN prod._aProdInput prodinput
JOIN prodinput._oProdInputType prodinputtype

LEFT JOIN homeplanet\Entity\attribute\Production supplier WITH supplier._iId = :id
JOIN supplier._oProdType suppliertype

WHERE suppliertype._oRessource = prodinputtype._oRessource
	
	AND supplier._iLocationX = prod._iLocationX
	AND supplier._iLocationY = prod._iLocationY
	
		');
		$oQuery->setParameters( [
				'id' => $oProd->getId(),
		]);
		
		return $oQuery->getResult();
	}
}