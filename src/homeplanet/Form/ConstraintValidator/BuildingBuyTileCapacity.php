<?php
namespace homeplanet\Form\ConstraintValidator;

use Symfony\Component\Validator\Constraint;
use homeplanet\Form\BuildingBuy;

/**
 * @Annotation
 */
class BuildingBuyTileCapacity extends Constraint {
	
	public $message = "Not enought {{capacity_type}} available on this location.";
	
	public function getTargets() {
		return self::CLASS_CONSTRAINT;
	}
	
	public function validatedBy() {
		return BuildingBuyTileCapacityValidator::class;
	}
	
}

