<?php
namespace homeplanet\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use homeplanet\Entity\Expression;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ConversationExpressionChoiceForm extends AbstractType {
	
	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'data_class' => ConversationExpressionChoice::class,
		]);
	}
	
	function getName() {
		return 'expression_form';
	}
	
	function buildForm( FormBuilderInterface $oBuilder, array $aOption ) {
		$oBuilder
			->add('expression', EntityType::class, [
				'class' => Expression::class,
				'choice_label' => 'label',
				'choices' => $oBuilder->getData()->getExpressionAr(),
				'expanded' => true,
				'choice_attr' => function( $val, $key, $index ) {
					return ['data-expressionview' => $val->getId() ];
				},
				'attr' => [
					'class' => 'btn-group',
				],
			])
			->add('submit', SubmitType::class, [ 
				'attr' => [ 'class' => 'btn-primary' ],
				'label' => 'End turn',
			])
		;
	}
}