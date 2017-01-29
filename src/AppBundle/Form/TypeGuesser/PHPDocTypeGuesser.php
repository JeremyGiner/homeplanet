<?php
namespace AppBundle\Form\TypeGuesser;

use Symfony\Component\Form\Guess\Guess;
use Symfony\Component\Form\Guess\TypeGuess;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormTypeGuesserInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Bundle\DoctrineBundle\Registry;


/**
* source http://symfony.com/doc/current/form/type_guesser.html
*
*/
class PHPDocTypeGuesser implements FormTypeGuesserInterface {
	
	protected $_oDoctrine;
	
	public function __construct( Registry $oDoctrine ) {
		$this->_oDoctrine = $oDoctrine;
	}
	
	public function guessPattern($class, $property) {
		return null;
	}
	public function guessMaxLength($class, $property) {
		return null;
	}
	public function guessRequired($class, $property) {
		return null;
	}
	public function guessType($class, $property) {
		$annotations = $this->readPhpDocAnnotations($class, $property);
		
		if (!isset($annotations['var'])) {
			return; // guess nothing if the @var annotation is not available
		}
		
		// otherwise, base the type on the @var annotation
		switch ($annotations['var']) {
			case 'string':
			// there is a high confidence that the type is text when
			// @var string is used
			return new TypeGuess(TextType::class, array(), Guess::HIGH_CONFIDENCE);
			
			case 'int':
			case 'integer':
			// integers can also be the id of an entity or a checkbox (0 or 1)
			return new TypeGuess(IntegerType::class, array(), Guess::MEDIUM_CONFIDENCE);
			
			case 'float':
			case 'double':
			case 'real':
			return new TypeGuess(NumberType::class, array(), Guess::MEDIUM_CONFIDENCE);
			
			case 'boolean':
			case 'bool':
			return new TypeGuess(CheckboxType::class, array(), Guess::HIGH_CONFIDENCE);
			case 'object' :
				return;
				return new TypeGuess(
					EntityType::class, 
						[
							'class' => $annotations['class'],
							'choice_label' => 'id'
						], 
						Guess::MEDIUM_CONFIDENCE
					);
			default:
			// there is a very low confidence that this one is correct
			return new TypeGuess(TextType::class, array(), Guess::LOW_CONFIDENCE);
		}
	}
	
	protected function readPhpDocAnnotations($class, $property) {
		$phpDocExtractor = new PhpDocExtractor();
		
		$oMetadataFactory = $this->_oDoctrine
			->getEntityManager()
			->getMetadataFactory();
		try{
		var_dump($oMetadataFactory->getMetadataFor($class));
		} catch( \Exception $e ) {
			var_dump($e->getMessage());
		}
		$doctrineExtractor = new DoctrineExtractor(
				$oMetadataFactory);
		
		var_dump($doctrineExtractor->getTypes($class, $property));
		
		$oPropertyInfo = new PropertyInfoExtractor([
				$phpDocExtractor,
				
			], [
			$phpDocExtractor
		]);
		
	//$reflectionProperty = new \ReflectionProperty($class, $property);
	//$phpdoc = $reflectionProperty->getDocComment();
	
	var_dump($oPropertyInfo->getTypes($class,$property));
	$a = $oPropertyInfo->getTypes($class,$property);
	if( $a == null )
		return null;
	var_dump($a[0]->getBuiltinType());
	// parse the $phpdoc into an array like:
	// array('type' => 'string', 'since' => '1.0')
	$phpdocTags = [
			'var' => $a[0]->getBuiltinType(), 
			'class' => $a[0]->getClassName(),
	];
	
	return $phpdocTags;
	}

// ...
}