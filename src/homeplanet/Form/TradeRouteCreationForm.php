<?php
namespace homeplanet\Form;

use homeplanet\Form\LocationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use homeplanet\Entity\attribute\ProductionType;
use Doctrine\ORM\EntityRepository;
use homeplanet\tool\TileValidatorRange;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TradeRouteCreationForm extends MultistepType {
	
	
//_____________________________________________________________________________
//	Builder

	
	function configureOptions( OptionsResolver $oResolver ) {
		parent::configureOptions($oResolver);
		$oResolver->setDefaults([
			'gameview' => null,
			'game' => null,
			'repo' => null,
		]);
	}
	
	function _buildFormByStep(
			FormBuilderInterface $oBuilder,
			$iStep, 
			$oData, 
			$aOption 
	) {
		switch( $iStep ) {
			case 0 :
				$a = [];
				for($i = 1; $i<=$oData->getPlayer()->getCartRemaining(); $i++)
					$a[$i] = $i;
				$oBuilder
					->add('name', TextType::class, ['label' => 'Name', 'required' => false])
					->add('location_begin', LocationType::class,[
						'gameview' => $aOption['gameview']
					])
					->add('production_type', EntityType::class, [
						'class' => ProductionType::class,
						'label' => 'Cargo type',
						'choice_label' => 'ressource.label',
						'query_builder' => function (EntityRepository $er) {
							return $er->createQueryBuilder('prodtype')
								->join('prodtype._aPawnType', 'pawntype')
								->join('prodtype._oRessource', 'ressource')
								->where('pawntype._iId = 10'/* trade route */);
						},
					])
					->add('level', ChoiceType::class, [
						'choices' => $a,
						'label' => 'Quantity',
					])
					->add('submit', SubmitType::class, [
						'label' => 'Next',
						'attr' => ['class' => 'btn-primary pull-right'], 
					]);
			return true;
			case 1 :
				$oBuilder
					->add('location_end', LocationType::class,[
						'label' => ' end',
						'data' => $oData->getLocationBegin(),
						'gameview' => $aOption['gameview'],
						'validator' => new TileValidatorRange(
							$aOption['game']->getWorldmap()->getTile(
								$oData->getLocationBegin()->getX(),
								$oData->getLocationBegin()->getY()
							), 
							3
						)
					])
					->add('confirm', SubmitType::class, [
						'label' => 'Confirm',
						'attr' => ['class' => 'btn-primary pull-right'],
					]);
			return true;
		}
		
		return false;
	}
	
}