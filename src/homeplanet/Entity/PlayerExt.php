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
use homeplanet\Entity\attribute\Population;


/**
 * @ORM\Entity
 * @ORM\Table(name="player_ext")
 */
class PlayerExt {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="player_id")
	 */
	protected $_iPlayerId;
	
	/**
	 * @ORM\Column(type="integer", name="contract")
	 */
	protected $_iContract;
	
	/**
	 * @ORM\OneToOne(targetEntity="Player")
	 * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
	 * @var Player
	 */
	protected $_oPlayer;
	
//_____________________________________________________________________________
//	Constructor
	/*
	public function __construct( Player $oPlayer, $sName ) {
		
		$this->_iPlayerId = $oPlayer->getId();
		$this->_sName = $sName;
		$this->_iCredit = 100;
		$this->_iIncome = 0;
	}*/
	
//_____________________________________________________________________________
//	Accessor
	
	public function getPlayerId() {
		return $this->_iPlayerId;
	}
	
	public function getContract() {
		return $this->_iContract;
	}
	public function getContractUsed() {
		return $this->getContract();
	}
	

}