<?php
namespace homeplanet\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use homeplanet\Entity\Expression;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class ConversationExpressionChoiceForm extends AbstractType {
	
	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setRequired('conversation_context');
		$oResolver->setDefaults([
			'data_class' => ConversationExpressionChoice::class,
			'em' => null,
		]);
	}
	
	function getName() {
		return 'expression_form';
	}
	
	function buildForm( FormBuilderInterface $oBuilder, array $aOption ) {
		$oBuilder
			->add('expression', EntityType::class, [
				'class' => Expression::class,
				'choice_label' => function( Expression $o ) {
					return $o->getLabel().' Hi';
				},
				'choices' => $oBuilder->getData()->getExpressionAr( $aOption['em'] ),
				'expanded' => true,
				'choice_attr' => function( Expression $val, $key, $index ) use($aOption) {
					
					$oValidator = $val->getRequirement();
					$disabled = $oValidator != null 
						&& ! $oValidator->validate( $aOption['conversation_context'] )
					;
					
					return [
						'data-expressionview' => $val->getId(),
						'disabled' => $disabled,	//used in finishView
					];
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
	
	function finishView( FormView $oView, FormInterface $oForm, array $aOption ) {
		
		// Quick fix TODO: improve
		foreach ( $oView->children['expression']->children as $children ) {
			$children->vars['disabled'] = isset($children->vars['attr']['disabled']) ? $children->vars['attr']['disabled'] :  $children->vars['disabled'];
		}
		
		foreach ( $oView->children['expression']->children as $key => $child ) {
			$child->vars['label_printo'] = $oView->children['expression']->vars['choices'][$key]->data;
		}
		
	}
}