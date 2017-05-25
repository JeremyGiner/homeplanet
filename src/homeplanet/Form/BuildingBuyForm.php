<?php
namespace homeplanet\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use homeplanet\Game;
use homeplanet\Entity\attribute\Location;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use homeplanet\Form\PawnTypeChoiceType;
use homeplanet\Form\BuildingBuy;
use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\PawnType;

class BuildingBuyForm extends AbstractType {

	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'data_class' => BuildingBuy::class,
			'gameview' => null,
		]);
	}
	
	function getName() {
		return 'BuildingBuyForm';
	}

	function buildForm(
			FormBuilderInterface $oBuilder,
			array $aOption
	) {
		
		/* @var $oData BuildingBuy */
		// TODO
		$oData  = $oBuilder->getData();
		$iCredit = $oData->getPlayer()->getCredit();
		
		$oBuilder
			->add('location', LocationType::class, [ 
				'label' => 'Location', 
				'gameview' => $aOption['gameview'],
			])
			->add('pawntype',PawnTypeChoiceType::class,[
				//'mapped' => false,
				'label' => false,
				'query_builder' => function(EntityRepository $er) {
					return $er->createQueryBuilder('u')
						->select('u,prodtype,prodinputtype')
						->leftJoin('u._aProdType', 'prodtype')
						->leftJoin('prodtype._aProdInputType', 'prodinputtype')
						->where('u._sLabel not in ( :filter)')
						->setParameter('filter', ['trade route']);
				},
				'choice_attr' => function( PawnType $val, $key, $index) use ( $iCredit ) {
					
					return ['disabled' => $val->getValue() > $iCredit ];
				},
			])
			->add('submit',SubmitType::class);
	}
}


