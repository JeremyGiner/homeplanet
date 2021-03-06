<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use Doctrine\ORM\EntityManager;
use homeplanet\Entity\attribute\Population;

/**
 * @ORM\Entity
 * @ORM\Table(name="knowledge")
 */
class Knowledge {
	
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
	 * @ORM\OneToOne(targetEntity="\homeplanet\Entity\KnowledgeCategory")
	 * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
	 * @var KnowledgeCategory
	 */
	protected $_oCategory;
	
	
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
	
	public function getCategory() {
		return $this->_oCategory;
	}
	
	
//_____________________________________________________________________________
//	Modifier

}