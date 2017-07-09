<?php
namespace homeplanet\Entity\attribute;

use Doctrine\ORM\Mapping as ORM;
use homeplanet\Entity\Ressource;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="attributetype")
 */
class AttributeType {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="id")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="string", name="label")
	 * @var string
	 */
	protected $_sLabel;
	
	
//______________________________________________________________________________
//	Constructor
	
	
//______________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	
}