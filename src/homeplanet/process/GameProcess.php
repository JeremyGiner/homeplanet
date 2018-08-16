<?php
namespace homeplanet\process;

use Doctrine\ORM\EntityManager;
use homeplanet\Entity\CharacterHistory;

class GameProcess {
	
	private $_oEntityManager;
	
//_____________________________________________________________________________
//	Constructor

	public function __construct( EntityManager $oEntityManager ) {
		$this->_oEntityManager = $oEntityManager;
	}

//_____________________________________________________________________________
//	Accessor

	public function getEntityManager() {
		return $this->_oEntityManager;
	}
	
//_____________________________________________________________________________
//	Process
	
	public function process() {
		
		$em = $this->getEntityManager();
		
		//_____________________________
		// Character process
		
		(new CharacterProcess( $em ))->process();
		
		//_____________________________
		// Turn process
		
		// Update prod
		// Update flux
		// Update cities pop growth
		// Increament turn
		$oQuery = $em
			->getConnection()
			->executeUpdate('CALL turn()')
		;
		
		$em->flush();
	}
	
	public function __invoke() {
		//TODO: check number of argument
		$this->process();
	}
}

