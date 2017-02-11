<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionInput;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\attribute\ProductionInputType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use homeplanet\Game;
use Doctrine\Common\Collections\Doctrine\Common\Collections;
use homeplanet\Entity\attribute\Population;
use homeplanet\Entity\attribute\Demand;
use homeplanet\Entity\Ressource;

/**
 * Create trade route entity
 */
class MerchantFactory extends Entity {
	
	/**
	 * @Assert\NotBlank()
	 * @var Location
	 */
	public $location;
	
	/**
	 * @Assert\NotBlank()
	 * @var ProductionType
	 */
	public $productionType;
	
	/**
	 * @var User
	 */
	public $user;
	
	/**
	 * @var Game
	 */
	protected $_oGame;
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct(
		Game $oGame
	) {
		$this->_oGame = $oGame;
	}
	
//_____________________________________________________________________________
//	Accessor

	
//_____________________________________________________________________________
//	Factory
	
	public function create() {
		
		$oEntityType = $this->_oGame->getEntityType(4/*id merchant*/);
		
		$o = new Entity( $oEntityType );
		$o->setUser( $this->user );
		
		// Location
		$o->addLocation( $this->location );
		
		// Addon
		$aAddOn = [];
		
		// Prod
		$oProd = new Production($o, $this->location, $this->productionType );
		$o->addProduction( $oProd );
		
		foreach( $this->productionType->getProdInputTypeAr() as $oProdInputType ) {
			$oProd->getProdInputAr()->add( 
				new ProductionInput( $oProd, $this->location, $oProdInputType ) );
		}
		
		$aAddOn[] = $oProd;
		
		return [
			'entity' => $o,
			'addOn' => $aAddOn
		];
	}
}