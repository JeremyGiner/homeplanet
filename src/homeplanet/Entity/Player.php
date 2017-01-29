<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionInput;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\attribute\ProductionInputType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use homeplanet\Entity\attribute\Population;
use Doctrine\Common\Collections\Doctrine\Common\Collections;
/**
 * @ORM\Entity
 * @ORM\Table(name="player")
 */
class Player {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="user_id")
	 */
	protected $_iUserId;
	
	/**
	 * @ORM\Column(type="string", name="name")
	 */
	protected $_sName;
	
	/**
	 * @ORM\Column(type="integer", name="credit")
	 */
	protected $_iCredit;
	
	/**
	 * @ORM\Column(type="integer", name="income")
	 */
	protected $_iIncome;
	
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( User $oUser, $sName ) {
		
		$this->_iUserId = $oUser->getId();
		$this->_sName = $sName;
		$this->_iCredit = 100;
		$this->_iIncome = 0;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getUserId() {
		return $this->_iUserId;
	}
	
	public function getName() {
		return $this->_sName;
	}
	
	public function getCredit() {
		return $this->_iCredit;
	}
	
	public function getIncome() {
		return $this->_iIncome;
	}
	
//_____________________________________________________________________________
//	Modifier

	public function setCredit( $i ) {
		$this->_iCredit = $i;
		return $this;
	}
	
	public function setName( $s ) {
		$this->_sName = $s;
		return $this;
	}

}