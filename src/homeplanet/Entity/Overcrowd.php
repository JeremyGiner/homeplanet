<?php
namespace homeplanet\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use homeplanet\Entity\attribute\Location;
use homeplanet\Entity\attribute\Production;
use homeplanet\Entity\attribute\ProductionInput;
use homeplanet\Entity\attribute\ProductionType;
use homeplanet\Entity\attribute\ProductionInputType;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use homeplanet\Entity\attribute\Population;
use Doctrine\Common\Collections\Doctrine\Common\Collections;
use homeplanet\Entity\attribute\EntityLocation;

/**
 * @ORM\Table(name="overcrowd")
 * @ORM\Entity(repositoryClass="homeplanet\Repository\OvercrowdRepository")
 */
class Overcrowd {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="ressource_id")
	 */
	protected $_iRessourceId;
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="location_x")
	 */
	protected $_iLocationX;
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", name="location_y")
	 */
	protected $_iLocationY;
	
	/**
	 * @ORM\Column(type="integer", name="quantity")
	 */
	protected $_iQuantity;
	
//_____________________________________________________________________________
//	Accessor
	
	public function getQuantity() {
		return $this->_iQuantity;
	}

	public function getRessourceId() {
		return $this->_iRessourceId;
	}
}