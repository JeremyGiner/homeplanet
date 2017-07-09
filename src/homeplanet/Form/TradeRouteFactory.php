<?php
namespace homeplanet\Form;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionInput;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\attribute\ProductionInputType;
use homeplanet\Game;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\Doctrine\Common\Collections;
use homeplanet\Entity\attribute\Population;
use homeplanet\Entity\attribute\Demand;
use homeplanet\Entity\Ressource;
use homeplanet\Entity\Pawn;
use homeplanet\Entity\Player;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Create trade route entity
 */
class TradeRouteFactory {
	
	/**
	 * @var Player
	 */
	private $_oPlayer;
	
	/**
	 * @Assert\NotBlank()
	 * @var string
	 */
	private $_sName;
	
	/**
	 * @Assert\NotBlank(groups={"step1"})
	 * @var Location
	 */
	private $_oLocationBegin;
	/**
	 * @Assert\NotBlank()
	 * @var Location
	 */
	private $_oLocationEnd;
	
	/**
	 * @var ProductionType
	 */
	private $_oProdType;
	//private $_iProdTypeId;
	
	/**
	 * @var int
	 */
	private $_iLevel;
	
//_____________________________________________________________________________
//	Constructor
	/*
	public function __construct(
		Player $oPlayer,
		$sName,
		Location $oLocationBegin = null,
		Location $oLocationEnd = null, 
		ProductionType $oProdType = null
	) {
		$this->_oPlayer = $oPlayer;
		$this->_sName = $sName;
		$this->_oLocationBegin = $oLocationBegin;
		$this->_oLocationEnd = $oLocationEnd;
		//$this->setProductionType($oProdType);
		$this->_oProdType = $oProdType;
	}*/
	
//_____________________________________________________________________________
//	Accessor

	public function getLocationBegin() {
		return $this->_oLocationBegin;
	}
	
	public function getLocationEnd() {
		return $this->_oLocationEnd;
	}
	
	public function getProductionType() {
		/*
		if( $this->_iProdTypeId === null )
			return null;
		return $this->_oGame->getProdType($this->_iProdTypeId);
		*/
		return $this->_oProdType;
	}
	
	public function getName() {
		return $this->_sName;
	}
	
	public function getPlayer() {
		return $this->_oPlayer;
	}
	
	public function getLevel() {
		return $this->_iLevel;
	}
	
//_____________________________________________________________________________
//	Modifier

	public function setPlayer( Player $oPlayer ) {
		$this->_oPlayer = $oPlayer;
		return $this;
	}
	
	public function setLocationBegin( Location $oLoc =null ) {
		$this->_oLocationBegin = $oLoc;
		return $this;
	}
	public function setLocationEnd( Location $oLoc =null ) {
		$this->_oLocationEnd = $oLoc;
		return $this;
	}
	
	public function setProductionType( ProductionType $oProdType = null ) {
		/*
		if( $oProdType === null )
			$this->_iProdTypeId = null;
		else
			$this->_iProdTypeId = $oProdType->getId();
		*/
		$this->_oProdType = $oProdType;
		return $this;
	}
	
	public function setName( $s ) {
		$this->_sName = $s;
		return $this;
	}
	
	public function setLevel( $i ) {
		$this->_iLevel = $i;
		return $this;
	}
	
//_____________________________________________________________________________
//	Validation
	
	/**
	 * @Assert\GreaterThanOrEqual(
	 *     value = 0,
	 *     message = "not enought contract available"
	 * )
	 */
	function getPlayerRemainingContractNew() {
		return $this->_oPlayer->getContractRemaining() - $this->_iLevel;
	}
	
//_____________________________________________________________________________
//	Creator
	
	public function create( $oGame ) {
		$oProdType = $this->_oProdType;
		$oBegin = $this->_oLocationBegin;
		$oEnd = $this->_oLocationEnd;
		$oEntityType = $oGame->getPawnType(10/*id trade route*/);
		
		$o = new Pawn( $oEntityType );
		$o->setPlayer( $this->_oPlayer );
		
		// Location
		$o->addLocation( $oBegin );
		$o->addLocation( $oEnd );
		
		// Addon
		$aAddOn = [];
		
		// Prod
		$oProd = new Production($o, $oEnd, $oProdType );
		$o->addProduction($oProd);
		
		foreach( $oProdType->getProdInputTypeAr() as $oProdInputType ) {
			$oProd->getProdInputAr()->add( 
				new ProductionInput( $oProd, $oBegin, $oProdInputType ) 
			);
		}
		
		//$aAddOn[] = $oProd;
		
		return [
			'entity' => $o,
			'addOn' => $aAddOn
		];
	}

}