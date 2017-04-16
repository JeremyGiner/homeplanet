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
use homeplanet\Form\EntityTypeChoiceType;
use homeplanet\Form\BuildingBuy;
use Doctrine\ORM\EntityRepository;

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
		
		$oBuilder
			->add('location', LocationType::class, [ 
				'label' => 'Location', 
				'gameview' => $aOption['gameview'],
			])
			->add('pawntype',EntityTypeChoiceType::class,[
				//'mapped' => false,
				'label' => false,
				'query_builder' => function(EntityRepository $er) {
					return $er->createQueryBuilder('u')
						->where('u._sLabel not in ( :filter)')
						->setParameter('filter', ['trade route']);
				},
			])
			->add('submit',SubmitType::class);
	}
}


