<?php
namespace homeplanet\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;
use homeplanet\Entity\PawnType as GameEntityType;


class PawnTypeChoiceType extends AbstractType {
	
	
	function getParent() {
		return EntityType::class;
	}
	
	function getBlockPrefix() {
		return 'pawntype';
	}
	
//_____________________________________________________________________________
//	Option
	
	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'class' => GameEntityType::class,
			'choice_label' => false,
			'expanded' => true,
		]);
	}
	
//_____________________________________________________________________________
//	Builder
	
	function buildForm( 
		FormBuilderInterface $oBuilder,
		array $aOption 
	) {

	}
	
//_____________________________________________________________________________
//	View
	
	
	
	public function buildView(FormView $oView, FormInterface $oForm, array $aOptions) {
		
	}
	
	public function finishView(FormView $oView, FormInterface $oForm, array $aOptions) {
		foreach ( $oView->children as $key => $child ) {
			$child->vars['label_printo'] = $oView->vars['choices'][$key]->data;
		}
	}
	
}
