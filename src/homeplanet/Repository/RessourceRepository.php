<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\City;

class RessourceRepository extends EntityRepository {
	
	public function findAll() {
		return $this->getEntityManager()
			->createQuery('SELECT ressource FROM homeplanet\Entity\Ressource ressource')
			->useQueryCache(true)
			->useResultCache(true)
			->getResult()
		;
	}
	
	
	
//_____________________________________________________________________________


	
}