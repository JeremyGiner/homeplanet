<?php
namespace homeplanet\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use homeplanet\Entity\Deck;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use homeplanet\Entity\Expression;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DeckForm extends AbstractType {
	
	public function configureOptions( OptionsResolver $oResolver ) {
		$oResolver
			->setDefaults([
				'data_class' => Deck::class,
			])
			->setRequired('em')
		;
		
	}
	
	public function buildForm(
		FormBuilderInterface $oBuilder,
		array $aOption
	) {
		//TODO: add deck validation
		$oBuilder
			->add('label', TextType::class, ['label' => 'Name'] )
			->add('expression_ar', EntityType::class, [
				'class' => Expression::class,
				'choice_label' => 'label',
				'choices' => $aOption['em']->getRepository(Expression::class)->findAll(),
				'multiple' => true,
			] )
			->add('submit',SubmitType::class, ['label' => 'Create'])
		;
		
	}
}