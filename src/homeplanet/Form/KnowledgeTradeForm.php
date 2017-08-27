<?php
namespace homeplanet\Form;

use Symfony\Component\Form\AbstractType;
use Proxies\__CG__\homeplanet\Entity\EntityType;
use homeplanet\Entity\Knowledge;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class KnowledgeTradeForm extends AbstractType {

	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'data_class' => KnowledgeTrade::class,
			'gameview' => null,
		]);
		$oResolver->setRequired(['character_self','character_target']);
	}
	
	function getName() {
		return 'KnowledgeTradeForm';
	}

	function buildForm(
			FormBuilderInterface $oBuilder,
			array $aOption
	) {
		/* @var $oData KnowledgeTrade */
		// TODO
		$oData = $oBuilder->getData();
		$iCredit = $oData->getPlayer()->getCredit();
		
		$oBuilder
			->add('given', EntityType::class, [ 
				'label' => 'Location', 
				'gameview' => $aOption['gameview'],
			])
			->add('demanded', EntityType::class,[
				'class' => Knowledge::class,
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


