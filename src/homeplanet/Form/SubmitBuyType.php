<?php
namespace homeplanet\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SubmitBuyType extends SubmitType {
	
	const CREDIT_FIELD_KEY = 'credit';
	
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
		$view->vars[self::CREDIT_FIELD_KEY] = $options['data']->getCost();
	}
	
	/**
	 * @param OptionsResolver $resolver
	 */
	public function configureOptions(OptionsResolver $resolver) {
		parent::configureOptions($resolver);
		$resolver
			->setRequired('data')
			->setDefaults([self::CREDIT_FIELD_KEY => null])
			->setDefined([self::CREDIT_FIELD_KEY])
		;
	}
}
