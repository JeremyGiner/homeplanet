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
use homeplanet\Game;
use Doctrine\Common\Collections\Doctrine\Common\Collections;
use homeplanet\Entity\attribute\Population;
use homeplanet\Entity\attribute\Demand;
use homeplanet\Entity\Ressource;

/**
 * Create trade route entity
 */
class TradeRouteFactory extends Entity {
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function create( 
			Game $oGame,
			User $oUser,
			Location $oBegin, 
			Location $oEnd, 
			ProductionType $oProdType
	) {
		
		$oEntityType = $oGame->getEntityType(10/*id trade route*/);
		
		$o = new Entity( $oEntityType );
		$o->setUser( $oUser );
		
		// Location
		$o->addLocation( $oBegin );
		$o->addLocation( $oEnd );
		
		// Addon
		$aAddOn = [];
		
		// Prod
		$oProd = new Production($o, $oEnd, $oProdType );
		$o->getProductionAr()->add($oProd);
		
		foreach( $oProdType->getProdInputTypeAr() as $oProdInputType ) {
			$oProd->getProdInputAr()->add( 
				new ProductionInput( $oProd, $oBegin, $oProdInputType ) 
			);
		}
		
		$aAddOn[] = $oProd;
		
		return [
			'entity' => $o,
			'addOn' => $aAddOn
		];
	}
}