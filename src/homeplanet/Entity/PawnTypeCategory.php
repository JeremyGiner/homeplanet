<?php

namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pawntypecategory")
 */
class PawnTypeCategory {
	/**
	 * @ORM\Id
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @var int
	 */
	protected $_iId;
	
	/**
	 * @ORM\Column(type="string", name="label")
	 * @var string
	 */
	protected $_sLabel;

	/**
	 * @ORM\OneToMany(targetEntity="PawnType", mappedBy="_oCategory")
	 * @var ArrayCollection
	 */
	protected $_aPawnType;
	
	
//_____________________________________________________________________________
//	Accessor
	
	public function getId() {
		return $this->_iId;
	}
	
	public function getLabel() {
		return $this->_sLabel;
	}
	
	/**
	 * @return Ressource[]
	 */
	public function getPawnTypeAr() {
		return $this->_aPawnType;
	}
}

