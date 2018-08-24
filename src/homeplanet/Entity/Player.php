<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\User;

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
	
	/**
	 * @ORM\OneToOne(targetEntity="Character")
	 * @ORM\JoinColumn(name="character_id", referencedColumnName="id")
	 * @var Character
	 */
	protected $_oCharacter;
	
	/**
	 * @ORM\OneToOne(targetEntity="House")
	 * @ORM\JoinColumn(name="house_id", referencedColumnName="id")
	 * @var House
	 */
	protected $_oHouse;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct( User $oUser, House $oHouse ) {
		
		$this->_oUser = $oUser;
		$this->_iCredit = 100;
		$this->_iIncome = 0;
		$this->_iCart = 1;
		$this->_iContractMax = 3;
		$this->_oHouse = $oHouse;
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getUserId() {
		return $this->_oUser->getId();
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
	
	public function getCharacter() {
		return $this->_oCharacter;
	}
	
	public function getHouse() {
		return $this->_oHouse;
	}
	
//_____________________________________________________________________________
//	Modifier

	public function setCredit( $i ) {
		$this->_iCredit = $i;
		return $this;
	}
	
	public function setCart( $i ) {
		$this->_iCart = $i;		
		return $this;
	}
	
	public function setCharacter( Character $oCharacter = null ) {
		$this->_oCharacter = $oCharacter;
		return $this;
	}
	
	public function increaseContractMax() {
		$this->_iContractMax++;
		return $this;
	}

}