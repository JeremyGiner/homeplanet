<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;
use homeplanet\validator\ValidatorAnd;
use homeplanet\validator\PointCost;

/**
 * @ORM\Table(name="expression")
 * @ORM\Entity
 */
class Expression {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="string", name="label")
	 */
	protected $_sLabel;
	
	/**
	 * @ORM\Column(type="string", name="description")
	 */
	protected $_sDescription;
	
	/**
	 * @ORM\Column(type="object", name="requirement")
	 */
	protected $_aRequirement;
	
	/**
	 * @ORM\Column(type="object", name="effect")
	 */
	protected $_aEffect;
	
	
//_____________________________________________________________________________
//	Constructor
	
	public function __construct() {
	}
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	public function getDescription() {
		return $this->_sDescription;
	}
	
	public function getEffect() {
		return $this->_aEffect;
	}
	
	public function getRequirement( Character $oCharacter ) {
		$o = new ValidatorAnd([
			new PointCost($oCharacter, 0, 1),
			new PointCost($oCharacter, 1, 1),
		]);
		return $o;
	}
	
//_____________________________________________________________________________
//	Modifier

}