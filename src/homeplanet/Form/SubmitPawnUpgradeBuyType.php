<?php
namespace homeplanet\Form;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use homeplanet\Form\data\PawnUpgradeBuy;
use Symfony\Component\Form\AbstractType;

class SubmitPawnUpgradeBuyType extends SubmitBuyType {
	
	const CAPACITY_REQUIEREMENT_FIELD_KEY = 'capacity_requirement_ar';
	
	function getBlockPrefix() {
		return 'submit_pawn_upgrade';
	}
	
	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver) {
		parent::configureOptions($resolver);
		$resolver
			->setRequired('data')
			->setDefaults([self::CAPACITY_REQUIEREMENT_FIELD_KEY => null])
			->setDefined([self::CAPACITY_REQUIEREMENT_FIELD_KEY])
		;
	}
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array                $options
	 */
	/*
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		parent::buildForm($builder, $options);
		
	}
	*/
	/**
	 * @param FormView      $view
	 * @param FormInterface $form
	 * @param array         $options
	 */
	public function buildView(FormView $view, FormInterface $form, array $options) {
		
		parent::buildView($view, $form, $options);
		$view->vars[self::CAPACITY_REQUIEREMENT_FIELD_KEY] = 
			$options['data']
				->getPawn()
				->getType()
				->getTileCapacityRequirementAr()
		;
	}
	
}
