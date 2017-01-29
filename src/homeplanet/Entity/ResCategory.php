<?php

namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rescategory")
 */
class ResCategory {
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
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
	 * @ORM\ManyToMany(targetEntity="\homeplanet\Entity\Ressource")
	 * @ORM\JoinTable(
	 *     name="ressource_rescategory",
	 *     joinColumns={@ORM\JoinColumn(name="rescat_id", referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="res_id", referencedColumnName="id")}
	 * )
	 * @var ArrayCollection
	 */
	protected $_aRessource;
	
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
	public function getRessourceAr() {
		return $this->_aRessource;
	}
}

