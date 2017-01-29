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
use homeplanet\Entity\EntityType as GameEntityType;


class EntityTypeChoiceType extends AbstractType {
	
	
	function getParent() {
		return EntityType::class;
	}
	
//_____________________________________________________________________________
//	Builder
	
	function configureOptions( OptionsResolver $oResolver ) {
		$oResolver->setDefaults([
			'class' => GameEntityType::class,
			'choice_label' => 'label',
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
	
}
