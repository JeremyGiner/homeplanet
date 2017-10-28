<?php
namespace homeplanet\Form;

use homeplanet\Form\LocationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use homeplanet\Entity\attribute\ProductionType;
use Doctrine\ORM\EntityRepository;
use homeplanet\tool\TileValidatorRange;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use homeplanet\Entity\attribute\Location;
use AppBundle\validator\ValidatorInArray;
use homeplanet\Entity\attribute\Transporter;
use Symfony\Component\Validator\Constraints\GroupSequence;

class TransportSetForm extends MultistepType {
	
	
//_____________________________________________________________________________
//	Builder

	
	function configureOptions( OptionsResolver $oResolver ) {
		parent::configureOptions($oResolver);
		
		$oResolver->setDefaults([
			'gameview' => null,
			'game' => null,
			'validation_groups' => function (FormInterface $form) {
				//TODO
				$step = $form->getConfig()->getOption('step');
				if( $step == 0 )
					return new GroupSequence( ['Default','step1'] );
				return ['Default','step1','step2'];
			}
		]);
	}
	
	function _buildFormByStep(
			FormBuilderInterface $oBuilder,
			$iStep, 
			$oData, 
			$aOption 
	) {
		/* @var $oData TransportSet */
		
		switch( $iStep ) {
			case 0 :
				$oPawn = $oData->getPawn();
				
				/* @var $oTransporter Transporter */
				$oTransporter = $oData->getPawn()->getAttribute('transport');
				
				$oBuilder
					->add('location_begin', LocationType::class,[
						'label' => 'Start',
						'gameview' => $aOption['gameview'],
						'validator' => $oTransporter->getTileValidator(),
					])
					->add('production_type', EntityType::class, [
						'class' => ProductionType::class,
						'label' => 'Cargo type',
						'choice_label' => 'ressource.label',
						'query_builder' => function (EntityRepository $er) use ($oPawn ){
							return $er->createQueryBuilder('prodtype')
								->join('prodtype._aPawnType', 'pawntype')
								->join('prodtype._oRessource', 'ressource')
								->where('pawntype._iId = '.$oPawn->getType()->getId())
							;
						},
					])
					/*
					->add('level', ChoiceType::class, [
						'choices' => range(1,pawn.grade), // get range entity grade
						'label' => 'Quantity',
					])
					*/
					->add('submit', SubmitType::class, [
						'label' => 'Next',
						'attr' => ['class' => 'btn-primary'], 
					]);
			return true;
			case 1 :
				$oTileBegin = $aOption['game']->getWorldmap()->getTile(
					$oData->getLocationBegin()->getX(),
					$oData->getLocationBegin()->getY()
				);
				
				// TODO: get pathfinder from transport attribute
				$oPathfinder = $oData->getPawn()
					->getAttribute('transport')
					->getPathfinder();
				$oPathfinder->propagate( $oData->getLocationBegin() );
				$oWorldmap = $oPathfinder->getWorldmap();
				$aMapping = $oPathfinder->getMapping();
				$aValidTile = [];
				if( $aMapping !== null )
					$aValidTile = array_map(function( $s ) use( $oWorldmap ) { 
						return $oWorldmap->getTileByLocation( Location::getFromString($s) );
					} , array_keys( $aMapping ) );
				
				$oBuilder
					->add('location_end', LocationType::class,[
						'label' => 'Destination',
						'data' => $oData->getLocationBegin(),
						'gameview' => $aOption['gameview'],
						'validator' => new ValidatorInArray( $aValidTile )
							/*
						'validator' => new TileValidatorRange(
							$oTileBegin, 
							3
						)
						*/
					])
					->add('confirm', SubmitType::class, [
						'label' => 'Confirm',
						'attr' => ['class' => 'btn-primary'],
					]);
			return true;
		}
		
		return false;
	}
	
}