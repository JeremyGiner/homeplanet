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
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 * @var User
	 */
	protected $_oUser;
	
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
	
	/**
	 * @ORM\Column(type="integer", name="contract_max")
	 */
	protected $_iContractMax;
	
	/**
	 * @ORM\OneToOne(targetEntity="PlayerExt",mappedBy="_oPlayer")
	 * @var PlayerExt
	 */
	protected $_oPlayerExt;
	
	/**
	 * @ORM\OneToOne(targetEntity="Sovereign")
	 * @ORM\JoinColumn(name="allegeance", referencedColumnName="id")
	 * @var Sovereign
	 */
	protected $_oAllegeance;
	
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( User $oUser, $sName ) {
		
		$this->_oUser = $oUser;
		$this->_sName = $sName;
		$this->_iCredit = 100;
		$this->_iIncome = 0;
		$this->_iCart = 1;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getUserId() {
		return $this->_oUser->getId();
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
	
	public function getContractMax() {
		return $this->_iContractMax;
	}
	
	public function getExt() {
		return $this->_oPlayerExt;
	}
	
	public function getContractPrice() {
		return $this->_iContractMax * $this->_iContractMax * 100;
	}
	
	public function getContractRemaining() {
		return $this->_iContractMax - $this->_oPlayerExt->getContractUsed();
	}
	
	public function getAllegeance() {
		return $this->_oAllegeance;
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
	
	public function setCart( $i ) {
		$this->_iCart = $i;		
		return $this;
	}
	
	public function increaseContractMax() {
		$this->_iContractMax++;
		return $this;
	}

}