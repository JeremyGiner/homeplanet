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
	
	/**
	 * @ORM\Column(type="integer", name="cart")
	 */
	protected $_iCart;
	
	/**
	 * @ORM\OneToOne(targetEntity="PlayerExt",mappedBy="_oPlayer")
	 * @var PlayerExt
	 */
	protected $_oPlayerExt;
	
	
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
	
	public function getId() {
		return $this->_iId;
	}
	
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
	
	public function getCart() {
		return $this->_iCart;
	}
	
	public function getExt() {
		return $this->_oPlayerExt;
	}
	
	public function getCartRemaining() {
		return $this->_iCart - $this->_oPlayerExt->getCartUsed();
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

}