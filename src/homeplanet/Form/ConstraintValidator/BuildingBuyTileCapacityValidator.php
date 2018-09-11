<?php
namespace homeplanet\Form\ConstraintValidator;

use Symfony\Component\Validator\Constraint;
use homeplanet\Form\BuildingBuy;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @Annotation
 */
class BuildingBuyTileCapacityValidator extends ConstraintValidator {
	
	public function validate( $oBuildingBuy, Constraint $constraint ) {
		
		// custom constraints should ignore null and empty values to allow
		// other constraints (NotBlank, NotNull, etc.) take care of that
		if( $oBuildingBuy === null )
			return;
		
		if( !$oBuildingBuy instanceof BuildingBuy )
			throw new UnexpectedTypeException($oBuildingBuy, BuildingBuy::class);
		
		$oTile = $oBuildingBuy->getTile();
		foreach( 
			$oBuildingBuy->getPawnType()->getTileCapacityRequirementAr() 
			as $oRequirement 
		) {
			
			if(
				$oTile->getCapacityRemaining($oRequirement->getType()->getId())
				<
				$oRequirement->getQuantity()
			)
				$this->context->buildViolation($constraint->message)
					->setParameter('{{capacity_type}}', $oRequirement->getType()->getLabel())
					->addViolation()
				;
		}
	}
	
	
}

