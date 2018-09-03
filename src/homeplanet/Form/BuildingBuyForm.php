<?php
namespace homeplanet\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\PawnType;

class BuildingBuyForm extends AbstractType {

	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'data_class' => BuildingBuy::class,
		])->setRequired(['game']);
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
			->add('tile', TileType::class, [ 
				'label' => 'Location', 
				'game' => $aOption['game'],
				'empty_data' => $oData->getTile(),
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


