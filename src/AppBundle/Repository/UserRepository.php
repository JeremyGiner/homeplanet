<?php
namespace homeplanet\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface {
	
	
//_____________________________________________________________________________
/*
	public function loadUserByUsername( $username ) {
		return $this->createQueryBuilder('u')
			->where('u.username = :username OR u.email = :email')
			->setParameter('username', $username)
			->setParameter('email', $username)
			->getQuery()
			->getOneOrNullResult();
	}
*/

}