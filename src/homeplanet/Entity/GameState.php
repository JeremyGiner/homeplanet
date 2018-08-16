<?php
namespace homeplanet\Entity;

use homeplanet\Game;
use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\attribute\TurnDate;
/**
 * @ORM\Entity
 * @ORM\Table(name="gamestate")
 */
class GameState {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="integer", name="turn")
	 * @var int
	 */
	protected $_iTurn;
	
	/**
	 * @ORM\Column(type="string", name="label")
	 * @var string
	 */
	protected $_sLabel;
	
//_____________________________________________________________________________
//	Constructor
	/*
	public function __construct( $sType, $iExpire, $oScope, $oParam ) {
		$this->_sType = $sType;
		$this->_iExpire = $iExpire;
		$this->_oScope = $oScope;
		$this->_oParam = $oParam;
		$this->_bProcessed = false;
	}*/
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getTurn() {
		return $this->_iTurn;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	public function getMonth() {
		return (new TurnDate($this->_iTurn))->getMonth();
	}
	public function getYear() {
		return (new TurnDate($this->_iTurn))->getYear();
	}
}