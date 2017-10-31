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
use Symfony\Component\Form\FormInterface;

class TradeRouteCreationForm extends MultistepType {
	
	
//_____________________________________________________________________________
//	Builder

	
	function configureOptions( OptionsResolver $oResolver ) {
		parent::configureOptions($oResolver);
		$oResolver->setDefaults([
			'repo' => null,
			'validation_groups' => function (FormInterface $form) {
				//TODO
				//var_dump( $form->getConfig()->getOption('step') );
				return ['form_step1'];
			}
		])->setRequired(['game','default_location',]);
	}
	
	function _buildFormByStep(
			FormBuilderInterface $oBuilder,
			$iStep, 
			$oData, 
			$aOption 
	) {
		/* @var $oData TradeRouteFactory */
		switch( $iStep ) {
			case 0 :
				$a = [];
				for($i = 1; $i<=$oData->getPlayer()->getContractRemaining(); $i++)
					$a[$i] = $i;
				$oBuilder
					->add('name', TextType::class, ['label' => 'Name', 'required' => false])
					->add('location_begin', LocationType::class,[
						'game' => $aOption['game'],
						'empty_data' => $aOption['default_location'],
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
						'game' => $aOption['game'],
						'empty_data' => $aOption['default_location'],
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