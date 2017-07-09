<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="attribute")
 */
class Attribute {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\ManyToOne(targetEntity="homeplanet\Entity\attribute\AttributeType")
	 * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
	 * @var Ressource
	 */
	protected $_oType;
	
	/**
	 * @ORM\Column(type="string", name="value")
	 * @var string
	 */
	protected $_sValue;
	
	
//______________________________________________________________________________
//	Constructor
	
	private function __construct( ) {
	}
	
//______________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getType() {
		return $this->_oType;
	}
	
	public function getValue() {
		return $this->_sValue;
	}
	
	
}